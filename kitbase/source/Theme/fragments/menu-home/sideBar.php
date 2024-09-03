<nav class="sidebar sidebar-offcanvas sidebar-fixed position-fixed" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-category">Menu</li>
        <?php foreach($pages as $ct => $page) {
            $style = '';
            if ($ct == count($pages)-1) {
                $style = 'style="border-bottom: 1px solid rgba(151, 151, 151, 0.27);"';
            }
            echo '<li '.$style.' class="nav-item '.(isset($page['active']) &&  $page['active']? "active" : "").'">';
            if (isset($page['dropdown']) && !empty($page['dropdown'])) {
                echo '<a class="nav-link" data-toggle="collapse" href="#'.$page['href'].'" aria-expanded="false" aria-controls="'.$page['href'].'">';
                echo '<span class="icon-bg"><i class="'.$page['class-icon'].'"></i></span>';

                echo '<span class="menu-title">'.$page['title'].'</span>';

                echo '<i class="menu-arrow"></i>';
                echo '</a>';
                echo '<div class="collapse" id="'.$page['href'].'">';
                echo '<ul class="nav flex-column sub-menu">';
                foreach($page['dropdown'] as $title => $href) {
                    echo '<li class="nav-item"> <a class="nav-link" href="/'.$href.'">'.$title.'</a></li>';
                }
                echo '</ul></div>';
            } else {
                echo '<a class="nav-link" href="/'.$page['href'].'">';
                echo '<span class="icon-bg"><i class="'.$page['class-icon'].'"></i></span>';

                echo '<span class="menu-title">'.$page['title'].'</span>';

                echo '</a>';
            }
            echo '</li>';

        }
        if (isset($avancado) && $avancado != false) {
        ?>
        <li class="nav-item sidebar-user-actions">
            <div class="sidebar-user-menu">
                <a href="<?= $avancado; ?>" class="nav-link"><span class="icon-sidebar-user-menu"><i class="mdi mdi-layers menu-icon"></i></span>
                    <span class="menu-title">Avançado</span></a>
            </div>
        </li>
        <?php }?>
        <li class="nav-item sidebar-user-actions">
            <div class="sidebar-user-menu">
                <a href="#" class="nav-link"><span class="icon-sidebar-user-menu"><i class="mdi mdi-logout menu-icon"></i></span>
                    <span class="menu-title">Sair</span></a>
            </div>
        </li>
    </ul>
</nav>