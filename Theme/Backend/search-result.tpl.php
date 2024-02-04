<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\QA
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;
use phpOMS\Utils\Parser\Markdown\Markdown;

$isEmpty = true;
?>
<?php
foreach ($this->data as $controller) :
    if (empty($controller)) {
        continue;
    }

    $first = \reset($controller);
?>
<div class="row">
    <div class="box col-xs-12">
        <h1><?= $first['module']; ?></h1>
    </div>
</div>
<?php if ($first['type'] === 'list_links') : ?>
    <?php foreach ($controller as $data) :
        if (empty($data)) {
            continue;
        }

        $isEmpty = false;

        $summary = $data['summary'];
        $summary = \trim($summary, " #\n");
    ?>
    <div class="row">
        <div class="col-xs-12">
            <section class="portlet">
            <?php if (!empty($data['title']) && !empty($summary)) : ?>
                <a href="<?= UriFactory::build($data['link']); ?>">
                <div class="portlet-head"><?= $this->printHtml(\trim($data['title'])); ?></div>
                </a>
            <?php elseif (!empty($data['title']) && empty($summary)) : ?>
                <a href="<?= UriFactory::build($data['link']); ?>">
                <div class="portlet-body"><?= $this->printHtml(\trim($data['title'])); ?></div>
                </a>
            <?php endif; ?>
            <?php if (!empty($summary)) : ?>
                <div class="portlet-body"><article><?= Markdown::parse($summary); ?></article></div>
            <?php endif; ?>
            <?php if (!empty($data['tags'])) : ?>
                <div class="portlet-foot">
                <?php foreach ($data['tags'] as $tag) : ?>
                    <span class="tag" style="background: <?= $this->printHtml($tag->color); ?>">
                        <?= empty($tag->icon) ? '' : ''; ?>
                        <?= $this->printHtml($tag->getL11n()); ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            </section>
        </div>
    </div>
    <?php endforeach; ?>
    <?php elseif ($first['type'] === 'list_accounts') : ?>
        <div class="row">
            <?php foreach ($controller as $data) :
            if (empty($data)) {
                continue;
            }

            $isEmpty = false;
        ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <section class="portlet">
                    <div class="portlet-head">
                        <a style="display: flex; align-items: center;" href="<?= UriFactory::build($data['link']); ?>">
                            <img class="profile-image" alt="account" loading="lazy"
                                    src="<?= UriFactory::build($data['image']); ?>">
                            <span style="margin-left: .5rem;"><?= $this->printHtml($data['title']); ?></span>
                        </a>
                    </div>
                    <div class="portlet-body">
                        <div>
                            <table class="wf-100" style="font-size: .9rem;">
                                <?php if (!empty($data['email'])) : ?><tr><td><a href=""><?= $this->printHtml($data['email']); ?></a><?php endif; ?>
                                <?php if (!empty($data['phone'])) : ?><tr><td><?= $this->printHtml($data['phone']); ?><?php endif; ?>
                                <?php if (!empty($data['city'])) : ?><tr><td><?= $this->printHtml($data['city']); ?><?php endif; ?>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php if ($isEmpty) : ?>
    <div class="row">
        <div class="col-xs-12">
            <section class="portlet">
                <div class="portlet-body"><?= $this->getHtml('NoResults'); ?></div>
            </section>
        </div>
    </div>
<?php endif; ?>