<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\QA
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

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
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet">
                <table class="default sticky"><tbody>
    <?php foreach ($controller as $data) :
        if (empty($data)) {
            continue;
        }

        $isEmpty = false;

        $summary = $data['summary'];
        $summary = \trim($summary, " #\n");
    ?>
    <tr data-href="<?= UriFactory::build($data['link']); ?>">
        <td class="wf-100">
            <a href="<?= UriFactory::build($data['link']); ?>">
                <?= $this->printHtml(\trim($data['title'])); ?>
            </a>
        <td class="sm-hidden">
            <?php if (!empty($data['tags'])) : ?>
                <div class="tag-list">
                <?php foreach ($data['tags'] as $tag) : ?>
                    <span class="tag" style="background: <?= $this->printHtml($tag->color); ?>">
                        <?= empty($tag->icon) ? '' : '<i class="g-icon">' . $this->printHtml($tag->icon) . '</i>'; ?>
                        <?= $this->printHtml($tag->getL11n()); ?>
                    </span>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
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