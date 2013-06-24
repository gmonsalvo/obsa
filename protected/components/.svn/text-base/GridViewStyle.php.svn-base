<?php

Yii::import('zii.widgets.grid.CGridView');

class GridViewStyle extends CGridView {

  /**
   * @var string a PHP expression that is evaluated for every table body row and whose result
   * is used as the CSS style for the row. In this expression, the variable <code>$row</code>
   * stands for the row number (zero-based), <code>$data</code> is the data model associated with
   * the row, and <code>$this</code> is the grid object.
   */
  public $rowCssStyleExpression;

  /**
   * Renders a table body row.
   * @param integer $row the row number (zero-based).
   */
  public function renderTableRow($row) {

    $data = $this->dataProvider->data[$row];

    $rowClass = '';
    if ($this->rowCssClassExpression !== null) {
      $rowClass = $this->evaluateExpression($this->rowCssClassExpression, array('row' => $row, 'data' => $data));
    }
    else if (is_array($this->rowCssClass) && ($n = count($this->rowCssClass)) > 0) {
      $rowClass = $this->rowCssClass[$row % $n];
    }

    $rowStyle = '';
    if ($this->rowCssStyleExpression !== null) {
      $rowStyle = $this->evaluateExpression($this->rowCssStyleExpression, array('row' => $row, 'data' => $data));
    }

    $rowAttributes = '';
    if ($rowClass) {
      $rowAttributes .= ' class="'.$rowClass.'" ';
    }
    if ($rowStyle) {
      $rowAttributes .= ' style="'.$rowStyle.'" ';
    }

    echo '<tr '.$rowAttributes.'>';

    foreach ($this->columns as $column) {
      $column->renderDataCell($row);
    }

    echo "</tr>\n";
    
  }

}