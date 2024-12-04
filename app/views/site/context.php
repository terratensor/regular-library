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

$this->title = "Контекст — $bookName";
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
      <div class="card pt-3">
        <div class="card-body">
          <div class="px-xl-5 px-lg-5 px-md-5 px-sm-3 paragraph">
              <?php foreach ($paragraphs as $paragraph): ?>
                <?php //var_dump($paragraph); ?>
                <div data-entity-id="<?= $paragraph->id; ?>">
                  <div class="paragraph-text">
                    <?= TextProcessor::widget(['text' => $paragraph->text]); ?>
                  </div>
                </div>

              <?php endforeach; ?>
            <div class="d-flex justify-content-start book-name pt-4">
              <div><strong><i><?= $paragraph->genre;?>. <?= $paragraph->author; ?> — <?= $paragraph->title; ?></i></strong></div>
            </div>
          </div>

        </div>
      </div>
      <div class="container container-pagination">
            <div class="detachable fixed-bottom">
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
