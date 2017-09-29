<?php

class SMODALS_List_Page
{
    function __construct()
    {
        $page = new WP_Admin_Page();
        $page->set_args( SMODALS::SETTINGS, array(
            'parent'      => false,
            'icon_url'    => 'dashicons-external',
            'title'       => 'Модальные окна',
            'menu'        => 'Модальные окна',
            'callback'    => array($this, 'page_render'),
            // 'validate'    => array($this, 'validate_options'),
            'permissions' => 'manage_options',
            'tab_sections'=> null,
            'columns'     => 2,
            ) );

        // $page->set_assets( array($this, 'set_assets') );

        $page->add_metabox( 'metabox1', 'Настройки библиотеки', array($this, 'metabox1_callback'), $position = 'side');
        $page->set_metaboxes();
    }

    // function set_assets()
    // {
    //     wp_enqueue_script( 'PLUGINNAME_Script', SMODALS_ASSETS . '/page.js', array('jquery'), '1.0', true );
    //     wp_localize_script('PLUGINNAME_Script', 'PLUGINNAME_opt', array(
    //         'nonce' => wp_create_nonce( 'PLUGINNAME' ),
    //         ) );
    // }

    /**
     * Основное содержимое страницы
     *
     * @access
     *     must be public for the WordPress
     */
    function page_render()
    {
        $table = new Example_List_Table();
        $table->set_fields( array('post_type' => SMODALS::SETTINGS) );
        $table->prepare_items();
        ?>

        <!-- <form id="movies-filter" method="get"> -->
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <!-- Now we can render the completed list table -->
        <?php
            $table->display();
            $create_link = get_admin_url() . 'post-new.php?post_type=' . strtolower('smodals');
        ?>
        <!-- </form> -->
        <a href="<?php echo $create_link ?>" class="button button-primary" style="margin-top: 5px;">Добавить</a>
        <?php
    }

    /**
     * Тело метабокса вызваное функций $this->add_metabox
     *
     * @access
     *     must be public for the WordPress
     */
    function metabox1_callback() {
        $animates = array(
            'fancybox' => array(
                'none'    => 'Без эффекта',
                "elastic" => 'Эластичность',
                "fade"    => 'Угасание',
                )
            );

        $modal_types = array(
            ''          => 'Не использовать',
            // 'fancybox2' => 'Fancybox 2',
            'fancybox3' => 'Fancybox 3',
            // 'magnific'   => 'Magnific Popup',
            // 'photoswipe' => 'PhotoSwipe',
            // 'lightgallery' => https://sachinchoolur.github.io/lightgallery.js/
            );

        $modal['fancybox2'] = array(
            array(
              'type'    => 'select',
              'id'      => 'lib_props][modal_type',
              'label'   => 'Библиотека',
              'options' => $modal_types,
              'value'   => 'fancybox2',
              ),
            array(
              'type'        => 'text',
              'id'          => 'lib_props][modal_selector',
              'label'       => 'Селектор',
              // 'desc'        => 'Модальное окно (Галерея, всплывающее окно)',
              'placeholder' => '.fancybox, .zoom',
              ),
            array(
              'type'      => 'checkbox',
              'id'        => 'lib_props][thumb',
              'label'     => 'Показывать превью',
              'desc'      => 'Показывать превью, если определена галерея атрибутом rel',
              ),
            array(
              'type'      => 'checkbox',
              'id'        => 'lib_props][fancybox_mousewheel',
              'label'     => 'Прокрутка мышью',
              'desc'      => 'Прокручивать изображения в fancybox окне колесом мыши',
              ),
            array(
              'type'      => 'select',
              'id'        => 'lib_props][openEffect',
              'label'     => 'Анимация при открытии',
              'options'   => $fancybox_animates,
              'defaults'  => 'elastic',
              ),
            array(
              'type'      => 'select',
              'id'        => 'lib_props][closeEffect',
              'label'     => 'Анимация при закрытии',
              'options'   => $fancybox_animates,
              'defaults'  => 'elastic',
              ),
            array(
              'type'      => 'select',
              'id'        => 'lib_props][nextEffect',
              'label'     => 'Эфект при перелистывании вперед',
              'options'   => $fancybox_animates,
              'defaults'  => 'fade',
              ),
            array(
              'type'      => 'select',
              'id'        => 'lib_props][prevEffect',
              'label'     => 'Эфект при перелистывании назад',
              'options'   => $fancybox_animates,
              'defaults'  => 'fade',
              ),
            array(
              'type'    => 'html',
              'id'      => 'for_group',
              'value'   => 'Для группировки объектов используйте одинаковый <em>rel</em>'
              ),
            );

        // revisions-next
        $modal['fancybox3'] = array(
            array(
              'type'    => 'select',
              'id'      => 'lib_props][modal_type',
              'label'   => 'Библиотека',
              'options' => $modal_types,
              'value'   => 'fancybox3',
              'input_class' => 'button right',
              ),
            array(
              'type'      => 'text',
              'id'        => 'lib_props][modal_selector',
              'label'     => '<hr> <strong>jQuery Селектор</strong> <br>',
              // 'desc'      => 'Модальное окно (Галерея, всплывающее окно)',
              'placeholder'   => '.fancybox, .zoom',
              // 'input_class' => 'button right',
              ),
            array(
              'type'    => 'select',
              'id'      => 'lib_props][openCloseEffect',
              'label'   => 'Эффект открытия',
              'options' => array(
                'false'     => 'Без эффекта',
                'zoom'        => 'Увеличение от объекта',
                'fade'        => 'Угасание',
                'zoom-in-out' => 'Увеличение из вне',
                ),
              'default' => 'zoom',
              ),
            array(
              'type'    => 'select',
              'id'      => 'lib_props][nextPrevEffect',
              'label'   => 'Эффект перелистывания',
              'options' => array(
                'false'       => 'Без эффекта',
                'fade'        => 'Угасание',
                'slide'       => 'Увеличение от объекта',
                'circular'    => 'Угасание',
                'tube'        => 'Туба',
                'zoom-in-out' => 'Увеличение из вне',
                'rotate'      => 'Переворот',
                ),
              'default' => 'fade',
              ),
            array(
              'type'    => 'html',
              'id'      => 'for_group',
              'value'   => 'Для группировки объектов используйте одинаковый <em>rel</em>'
              ),
            );

        $modal['magnific'] = array(
            array(
              'type' => 'select',
              'id'   => 'modal_type',
              'label'=> 'Библиотека',
              'options' => $modal_types,
              'value' => 'magnific',
              ),
            array(
              'type'      => 'text',
              'id'        => 'magnific',
              'label'     => 'Селектор',
              // 'desc'      => 'Модальное окно (Галерея, всплывающее окно)',
              'placeholder'   => '.magnific, .zoom',
              ),
            );

        $modal['photoswipe'] = array(
            array(
              'type' => 'select',
              'id'   => 'modal_type',
              'label'=> 'Библиотека',
              'options' => $modal_types,
              'value' => 'photoswipe',
              ),
            array(
              'type'      => 'text',
              'id'        => 'photoswipe',
              'label'     => 'Селектор',
              // 'desc'      => 'Модальное окно (Галерея, всплывающее окно)',
              'placeholder'   => '.photoswipe, .zoom',
              ),
            );

        $form = new WP_Admin_Forms( $modal['fancybox3'], $is_table = false, $args = array(
            // Defaults:
            // 'admin_page'  => true,
            // 'item_wrap'   => array('<p>', '</p>'),
            // 'form_wrap'   => array('', ''),
            // 'label_tag'   => 'th',
            // 'hide_desc'   => false,
            ) );
        echo $form->render();

        submit_button( 'Сохранить', 'primary right', 'save_changes' );
        echo '<div class="clear"></div>';
    }
}
new SMODALS_List_Page();