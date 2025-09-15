<?php
function render_breadcrumb($sec, $sub = null, $custom = [])
{
    $sections = [
        'home' => ['label' => 'Inicio', 'url' => 'index.php?sec=home'],
        'documents' => ['label' => 'Documentos', 'url' => 'index.php?sec=documents'],
        'downloads' => ['label' => 'Descargas', 'url' => 'index.php?sec=downloads'],
        'compare' => ['label' => 'Comparar', 'url' => 'index.php?sec=compare'],
        'profile' => ['label' => 'Perfil', 'url' => 'index.php?sec=profile'],
    ];

    $breadcrumb = [];
    $breadcrumb[] = '<a href="index.php?sec=home">Inicio</a>';

    if ($sec !== 'home' && isset($sections[$sec])) {
        if (
            ($sec === 'documents' && $sub && is_numeric($sub)) ||
            ($sec === 'profile' && $sub === 'edit') ||
            !empty($custom)
        ) {
            $breadcrumb[] = '<a href="' . $sections[$sec]['url'] . '">' . $sections[$sec]['label'] . '</a>';
        } else {
            $breadcrumb[] = '<span>' . $sections[$sec]['label'] . '</span>';
        }
    }

    if ($sec === 'documents' && $sub && is_numeric($sub)) {
        $document = getDocuments($sub);
        $breadcrumb[] = '<span>' . $document['code'] . '</span>';
    } elseif ($sec === 'profile' && $sub === 'edit') {
        $breadcrumb[] = '<span>Editar contraseña</span>';
    } elseif (!empty($custom)) {
        $breadcrumb[] = '<span>' . $custom['label'] . '</span>';
    }

    echo '<nav class="breadcrumb">' . implode(' <span class="breadcrumb__sep">&gt;</span> ', $breadcrumb) . '</nav>';
}
