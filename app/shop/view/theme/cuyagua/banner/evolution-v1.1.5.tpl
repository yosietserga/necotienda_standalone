<?php $classes = ($settings['class']) ? $settings['class'] : ''; ?>

<li id="<?php echo $widgetName;?>" class="banner-evolution <?php echo $classes ?> nt-editable"> 
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 
    <div class="widget-content" id="<?php echo $widgetName; ?>Content" data-banner="evolution">
        <?php foreach ($banner['items'] as $item) { ?>
            <article class="item">
                <?php if (!empty($item['image'])) { ?>
                    <figure class="thumb">
                        <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />
                    </figure>
                <?php } ?>
                <section class="details">
                    <?php if (!empty($item['title'])) { ?>
                        <h2 class="title">
                           <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">
                              <?php echo $item['title']; ?>
                           </a>
                        </h2>
                    <?php } ?>
                    <?php if (!empty($item['description'])) { ?>
                        <p class="body">
                           <?php echo $item['description']; ?>
                        </p>
                    <?php } ?>
                    <?php if (!empty($item['link']) && (!empty($item['title']) || !empty($item['description']))) { ?>
                        <div class="btn btn--primary">
                           <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">
                              <?php echo $Language->get('text_more_details'); ?> 
                           </a>
                        </div>
                    <?php } ?>
                </section>
            </article>
        <?php } ?>
    </div>
</li>

<script>
    (function () {
        window.deferPlugin('slick', function () {
            var config = {
               slidesToShow: 1,
               slidesToScroll: 1,
               infinite: true,
               dots: true,
               fade: true,
               arrows: true,
               slide: 'article',
               prevArrow: '<button type="button" class="slick-prev"><?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/angle-left.tpl"); ?></button>',
               nextArrow: '<button type="button" class="slick-next"><?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/angle-right.tpl"); ?></button>'

            };
            $("#<?php echo $widgetName; ?> *[data-banner='evolution']").slick(config);
        });
    })();
</script>