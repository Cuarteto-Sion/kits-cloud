<style>
    .content.container {
        display: flex;
        gap: 1em;
        flex-wrap: wrap;
    }

    .content > a {
        color: inherit;
        text-transform: none;
    }

    .content .card {
        flex: 1 0 21%;
        flex-grow: 0;
        cursor: default;
    }

    .content .card:hover {
        background-color: #f0f0f0;
    }

    .card-body > * {
        display: flex;
        align-self: center;
        justify-self: start;
        margin: 0px;
    }

    .card-body p {
        white-space: nowrap;
        text-overflow: ellipsis;
        display: block;
        overflow: hidden;
    }

    @media only screen and (max-width: 990px) {
        .content .card {
            flex: 1 0 45%;
            flex-grow: 0;
        }    
    }

    @media only screen and (max-width: 600px) {
        .content .card {
            flex: 1 0 100%;
            flex-grow: 0;
        }    
    }
</style>
<div class="content container mt-3 pt-3">
    <?php if ($parent !== false) : ?>
        <a href="?p=<?php echo urlencode($parent) ?>" class="card">
            <div class="card-body"><p><i class="fa fa-chevron-circle-left go-back mr-3"></i>Volver</p></div>
        </a>
    <?php endif; ?>
    <?php
        foreach($folders as $f) {
            $img = $is_link ? 'icon-link_folder' : 'fa fa-folder-o';
    ?>
            <a href="?p=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>" class="card">
                <div class="card-body"><p><i style="font-size: 1.5em;" class="<?php echo $img ?> mr-3"></i><?= $f ?></p></div>
            </a>
    <?php
        }
        foreach($files as $f) {
            $img = $is_link ? 'fa fa-file-text-o' : Utils\Icons\fm_get_file_icon_class($path . '/' . $f);
            $filelink = '?p=' . urlencode(FM_PATH) . '&amp;view=' . urlencode($f);
            $fileext = Utils\Files\get_file_extension($f);
            $file_url = FM_ROOT_URL . fm_convert_win((FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $f);

            $bg_color = null;

            switch( $fileext ) {
                case "mp3":
                    $bg_color = "#B3E5FC";
                    break;
            }
    ?>
        <a class="card" href="<?= fm_enc($file_url) ?>" target="_blank" title="<?php echo $f ?>">
            <div class="card-body" style="background-color: <?= $bg_color ?>;"><p><i style="font-size: 1.5em;" class="<?php echo $img ?> mr-3"></i><?= $f ?></p></div>
        </a>
    <?php
        }
    ?>
</div>
