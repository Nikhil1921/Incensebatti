<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-header">
    <h5><?= $title ?> <?= $operation ?></h5>
</div>
<div class="card-body">
    <?= form_open_multipart('', '', ['image' => isset($data['image']) ? $data['image'] : '']) ?>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <?= form_label('Category name', 'cat_id', 'class="col-form-label"') ?>
                    <select name="cat_id" id="cat_id" class="form-control" data-value="<?= set_value('sub_cat_id') ? set_value('sub_cat_id') : (isset($data['sub_cat_id']) ? e_id($data['sub_cat_id']) : '') ?>">
                        <option value="">Select Category</option>
                        <?php foreach ($this->cats as $v): ?>
                            <option value="<?= e_id($v['id']) ?>" <?= set_value('cat_id') ? set_select('cat_id', e_id($v['id'])) : (isset($data['cat_id']) && $data['cat_id'] == $v['id'] ? 'selected' : '') ?>><?= $v['cat_name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <?= form_error('cat_id') ?>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?= form_label('Sub Category name', 'sub_cat_id', 'class="col-form-label"') ?>
                    <select name="sub_cat_id" id="sub_cat_id" class="form-control">
                    </select>
                    <?= form_error('sub_cat_id') ?>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?= form_label('Title', 'p_title', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "text",
                        'id' => "p_title",
                        'name' => "p_title",
                        'onkeyup' => "document.getElementById('p_slug').value = this.value.trim().replaceAll(' ', '-')",
                        'maxlength' => 100,
                        'required' => "",
                        'value' => set_value('p_title') ? set_value('p_title') : (isset($data['p_title']) ? $data['p_title'] : '')
                    ]); ?>
                    <?= form_error('p_title') ?>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?= form_label('Product Slug', 'p_slug', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "text",
                        'id' => "p_slug",
                        'name' => "p_slug",
                        'maxlength' => 100,
                        'readonly' => 'readonly',
                        'required' => "",
                        'value' => set_value('p_slug') ? set_value('p_slug') : (isset($data['p_slug']) ? $data['p_slug'] : '')
                    ]); ?>
                    <?= form_error('p_slug') ?>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?= form_label('Quantity', 'p_qty', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "text",
                        'id' => "p_qty",
                        'name' => "p_qty",
                        'maxlength' => 10,
                        'required' => "",
                        'value' => set_value('p_qty') ? set_value('p_qty') : (isset($data['p_qty']) ? $data['p_qty'] : '')
                    ]); ?>
                    <?= form_error('p_qty') ?>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <?= form_label('Price', 'p_price', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "text",
                        'id' => "p_price",
                        'name' => "p_price",
                        'maxlength' => 10,
                        'required' => "",
                        'value' => set_value('p_price') ? set_value('p_price') : (isset($data['p_price']) ? $data['p_price'] : '')
                    ]); ?>
                    <?= form_error('p_price') ?>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group m-t-15 m-checkbox-inline mb-0 custom-radio-ml">
                    <?= form_label('Option To show', '', 'class="col-form-label"') ?>
                    <br>
                    <div class="radio radio-primary">
                        <?= form_radio([
                            'value' => 'All',
                            'id' => "all",
                            'name' => "p_show",
                            'checked' => set_value('p_show') ? set_radio('p_show', 'All') : (isset($data['p_show']) && $data['p_show'] == 'All' ? 'checked' : TRUE)
                        ]); ?>
                        <?= form_label('No One Select', 'all', 'class="mb-0"') ?>
                    </div>
                    <div class="radio radio-primary">
                        <?= form_radio([
                            'value' => 'Top Selling',
                            'id' => "selling",
                            'name' => "p_show",
                            'checked' => set_value('p_show') ? set_radio('p_show', 'Top Selling') : (isset($data['p_show']) && $data['p_show'] == 'Top Selling' ? 'checked' : FALSE)
                        ]); ?>
                        <?= form_label('Top Selling', 'selling', 'class="mb-0"') ?>
                    </div>
                    <div class="radio radio-primary">
                        <?= form_radio([
                            'value' => 'Top Featured',
                            'id' => "featured",
                            'name' => "p_show",
                            'checked' => set_value('p_show') ? set_radio('p_show', 'Top Featured') : (isset($data['p_show']) && $data['p_show'] == 'Top Featured' ? 'checked' : FALSE)
                        ]); ?>
                        <?= form_label('Top Featured', 'featured', 'class="mb-0"') ?>
                    </div>
                </div>
            </div>
            <div class="col-<?= isset($data['image']) ? 4 : 6 ?>">
                <div class="form-group">
                    <?= form_label('Image <span class="text-danger">(Size should be 250*250)</span>', 'image', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "file",
                        'id' => "image",
                        'name' => "image",
                    ]); ?>
                </div>
            </div>
            <?php if (isset($data['image'])): ?>
                <div class="col-2">
                    <?= img(['src' => $this->path.$data['image'], 'width' => '100%', 'height' => '120']); ?>
                </div>
            <?php endif ?>
            <div class="col-12">
                <div class="form-group">
                    <?= form_label('Description', 'description', 'class="col-form-label"') ?>
                    <?= form_textarea([
                        'class' => "form-control",
                        'type' => "text",
                        'rows'=>"3",
                        'id' => "description",
                        'name' => "description",
                        'required' => "",
                        'value' => set_value('description') ? set_value('description') : (isset($data['description']) ? $data['description'] : '')
                    ]); ?>
                    <?= form_error('description') ?>
                </div>
            </div>
            <div class="col-12"></div>
            <div class="col-3">
                <?= form_button([
                    'type'    => 'submit',
                    'class'   => 'btn btn-outline-primary btn-block col-12',
                    'content' => 'SAVE'
                ]); ?>
            </div>
            <div class="col-3">
                <?= anchor("$url", 'CANCEL', 'class="btn btn-outline-danger col-12"'); ?>
            </div>
        </div>
    <?= form_close() ?>
</div>