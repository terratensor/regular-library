<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var ParagraphDataProvider $results */

/** @var string $bookName */

use app\widgets\ScrollWidget;
use src\helpers\SearchResultHelper;
use src\helpers\TextProcessor;
use src\models\Paragraph;
use src\repositories\ParagraphDataProvider;
use yii\bootstrap5\LinkPager;
use yii\data\Pagination;

$this->title = $bookName;
$fragment = Yii::$app->request->get()['f'] ?? 0;

?>
<div class="container-fluid quote-results">

    <?php
    // Property totalCount пусто пока не вызваны данные модели getModels(),
    // сначала получаем массив моделей, потом получаем общее их количество
    /** @var Paragraph[] $paragraphs */
    $paragraphs = $results->getModels();    

    $pagination = new Pagination(
        [
            'totalCount' => $results->getTotalCount(),
            'defaultPageSize' => Yii::$app->params['searchResults']['pageSize'],
        ]
    );
    ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card pt-3 my-3">
        <div class="card-body p-0">
        <div class="px-xl-5 px-lg-5 px-md-5 px-sm-3 paragraph">
            <?php foreach ($paragraphs as $paragraph): ?>
              <div id="<?= $paragraph->position;?>" data-entity-id="<?= $paragraph->id; ?>"
                class="<?= $fragment == $paragraph->position ? "card border-primary" : "" ?>">
                <div class="card-body">

                <div class="paragraph-text">
                  <?= TextProcessor::widget(['text' => $paragraph->text]); ?>
                </div>
                </div>
              </div>                
            <?php endforeach; ?>
            <div class="d-flex justify-content-start book-name pt-4">
              <div><strong><i><?= $bookName; ?></i></strong></div>
            </div>
          </div>
        </div>
      </div>
      <div class="container container-pagination d-print-none">
            <div class="detachable">
                <?php echo LinkPager::widget(
                    [
                        'pagination' => $pagination,
                        'firstPageLabel' => true,
                        'lastPageLabel' => false,
                        'maxButtonCount' => 5,
                        'options' => [
                            'class' => 'd-flex justify-content-center'
                        ],
                        'listOptions' => ['class' => 'pagination mb-0']
                    ]
                ); ?>
            </div>
        </div>
    </div>
  </div>
</div>
<?= ScrollWidget::widget(['data_entity_id' => isset($paragraph) ? $paragraph->id : 0]); ?>
