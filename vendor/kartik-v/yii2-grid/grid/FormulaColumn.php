<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-grid
 * @version 1.6.0
 */

namespace kartik\grid;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * A FormulaColumn to calculate values based on other column indexes
 * for the Grid widget [[\kartik\widgets\GridView]]
 *
 * DataColumn is the default column type for the [[GridView]] widget.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class FormulaColumn extends DataColumn
{

    const SUMMARY = -10000;
    const FOOTER = -20000;

    /**
     * @var boolean automatically generate the footer. If set to `true`, it will
     * use the same formula to generate the footer. If set to `false`, will use
     * the default footer.
     */
    public $autoFooter = true;

    /**
     * Gets the value of a column
     *
     * @param integer $i the index of the grid column (the first column
     * in the grid will be zero indexed). Note a column's index is to be
     * considered, even if the `visible` property is set to false.
     * @param array $params which will contain these keys:
     * - model: mixed the data model being rendered
     * - key: mixed the key associated with the data model
     * - index: integer the zero-based index of the data item among
     *   the item array returned by [[GridView::dataProvider]].
     * @throws InvalidConfigException
     */
    public function col($i, $params = [])
    {
        if (empty($this->grid->columns[$i])) {
            throw new InvalidConfigException("Invalid column index {$i} used in FormulaColumn.");
        }
        if (!isset($this->value) || !$this->value instanceof \Closure) {
            throw new InvalidConfigException("The 'value' must be set and defined as a `Closure` function for a FormulaColumn.");
        }
        $col = $this->grid->columns[$i];
        if ($col === $this) {
            throw new InvalidConfigException("Self-referencing FormulaColumn at column {$i}.");
        }
        $model = null;
        $key = null;
        $index = null;
        extract($params);
        if ($index == self::SUMMARY) {
            return $col->getPageSummaryCellContent();
        } elseif ($index == self::FOOTER) {
            return $col->getFooterCellContent();
        } else {
            return $col->getDataCellValue($model, $key, $index);
        }
    }

    /**
     * Gets the raw page summary cell content.
     *
     * @return string the rendering result
     */
    protected function getPageSummaryCellContent()
    {
        if ($this->pageSummary === true || $this->pageSummary instanceof \Closure) {
            $summary = call_user_func($this->value, null, null, self::SUMMARY, $this);
            return ($this->pageSummary === true) ? $summary : call_user_func($this->pageSummary, $summary, [], $this);
        }
        return parent::getPageSummaryCellContent();
    }

    /**
     * Renders the page summary cell content.
     *
     * @return string the rendering result
     */
    protected function renderPageSummaryCellContent()
    {
        if ($this->hidePageSummary) {
            return $this->grid->emptyCell;
        }
        $content = $this->getPageSummaryCellContent();
        if ($this->pageSummary === true) {
            return $this->grid->formatter->format($content, $this->format);
        }
        return ($content === null) ? $this->grid->emptyCell : $content;
    }

    /**
     * Get the raw footer cell content.
     *
     * @return string the rendering result
     */
    protected function getFooterCellContent()
    {
        if ($this->autoFooter) {
            return call_user_func($this->value, null, self::FOOTER, $this);
        }
        return parent::getFooterCellContent();
    }

    /**
     * Formatted footer cell content.
     *
     * @return string the rendering result
     */
    protected function renderFooterCellContent()
    {
        if ($this->autoFooter) {
            return $this->grid->formatter->format($this->getFooterCellContent(), $this->format);
        }
        return parent::renderFooterCellContent();
    }

}