<div class="wks" id="wks-box">
    <div class="header-wks" id="header-wks-box">
        <ul class="header-wks__menu--left menu-left" id="menu-left">
            <li class="menu-left__menu-left-item menu-left-item" id="user-item">
                MB
            </li>
            <li class="menu-left__menu-left-item menu-left-item user-dropdown-parent" id="user-email">
                <?php echo $_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname'] . ' | ' . $_SESSION['role_name']; ?>
            </li>
        </ul>

        <ul class="user-dropdown-menu" id="user-dropdown-menu">
            <li class="user-dropdown-item">
                <?php echo $_SESSION['user_email']; ?>
            </li>
            <a href="../profil.php" class="user-dropdown-item-link">Profil</a>
        </ul>

        <ul class="header-wks__menu--center menu-center">
            <li class="menu-center__menu-center-item menu-center-item">
                <?php 
                    if($_SESSION['role_name'] !== "Super admin") { 
                        echo "Centre : ".$_SESSION['place_name'] . ' | ' . 'Année : ' . $_SESSION['year_name'] . ' | ' . 'Cycle : ' . $_SESSION['cycle_name'];
                    }else{ 
                        echo "GSC - Accès Facile à l'Éducation";
                    } 
                ?>
            </li>
        </ul>

        <ul class="header-wks__menu--right menu-right">
            <li class="menu-right__menu-right-item menu-right-item">
                Paramètres
                <ul class="submenu">
                    <li class="submenu-item">
                        <span class="submenu-text">Années</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-years/add-school-year.php" class="subitem-item">Ajouter une année</a>
                            <a href="/backend/Views/pages/settings/school-years/list-school-year.php" class="subitem-item">Listes des années</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Centres</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-places/add-school-place.php" class="subitem-item">Ajouter un centre</a>
                            <a href="/backend/Views/pages/settings/school-places/list-school-place.php" class="subitem-item">Liste des centres</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Cycles</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-cycles/add-school-cycle.php" class="subitem-item">Ajouter un cycle</a>
                            <a href="/backend/Views/pages/settings/school-cycles/list-school-cycle.php" class="subitem-item">Liste des cycles</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Classes</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-grades/add-school-grade.php" class="subitem-item">Ajouter une classe</a>
                            <a href="/backend/Views/pages/settings/school-grades/list-school-grade.php" class="subitem-item">Liste des classes</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Séries</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-series/add-school-serie.php" class="subitem-item">Ajouter une série</a>
                            <a href="/backend/Views/pages/settings/school-series/list-school-serie.php" class="subitem-item">Liste des séries</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Salles</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-rooms/add-school-room.php" class="subitem-item">Ajouter une salle</a>
                            <a href="/backend/Views/pages/settings/school-rooms/list-school-room.php" class="subitem-item">Liste des salles</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Matières</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-courses/add-school-course.php" class="subitem-item">Ajouter une matière</a>
                            <a href="/backend/Views/pages/settings/school-courses/list-school-course.php" class="subitem-item">Liste des matières</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Rôles</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-roles/add-school-role.php" class="subitem-item">Ajouter un rôle</a>
                            <a href="/backend/Views/pages/settings/school-roles/list-school-role.php" class="subitem-item">Liste des rôles</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Droits</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-access/add-school-access.php" class="subitem-item">Ajouter un droit</a>
                            <a href="/backend/Views/pages/settings/school-access/list-school-access.php" class="subitem-item">Liste des droits</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Scolarités</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-schooling/add-schooling.php" class="subitem-item">Ajouter une scolarité</a>
                            <a href="/backend/Views/pages/settings/school-schooling/list-schooling.php" class="subitem-item">Liste des scolarités</a>
                        </nav>
                    </li>

                    <li class="submenu-item">
                        <span class="submenu-text">Frais</span>
                        <nav class="subitem-menu">
                            <a href="/backend/Views/pages/settings/school-fees/add-fee.php" class="subitem-item">Ajouter un frais</a>
                            <a href="/backend/Views/pages/settings/school-fees/list-fee.php" class="subitem-item">Liste des frais</a>
                        </nav>
                    </li>
                </ul>
            </li>
        <li class="menu-right__menu-right-item menu-right-item" id="logout">
            Déconnexion
        </li>
    </ul>
</div>