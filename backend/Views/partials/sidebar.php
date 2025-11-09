<?php
     require_once __DIR__ . "/../../helpers/auth_helpers.php";

     // redirection si non connecté
     if (!isset($_SESSION['user_id'])) {
     header("Location: /gsc/backend/Views/pages/login.php");
     exit;
     }
?>

<div class="sidebar" id="sidebar">
     <ul class="sidebar__navigation navigation" id="sidebar-content-box">

          <!-- Gestion des personnels -->
          <?php if (hasSectionAccess('personals')): ?>
               <li class="navigation__navigation-item navigation-item">
                    <h3 class="navigation-item__title">Gestion des personnels</h3>
                    <nav class="navigation-item__subnavigation subnavigation">
                         <?php if (hasAccess('add-personal')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/personals/add-personal.php">
                                   Ajouter un personnel
                              </a>
                         <?php endif; ?>

                         <?php if (hasAccess('list-personal')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/personals/list-personal.php">
                                   Liste des personnels
                              </a>
                         <?php endif; ?>
                    </nav>
               </li>
          <?php endif; ?>

          <!-- Gestion des enseignants -->
          <?php if (hasSectionAccess('teachers')): ?>
               <li class="navigation__navigation-item navigation-item">
                    <h3 class="navigation-item__title">Gestion des enseignants</h3>
                    <nav class="navigation-item__subnavigation subnavigation">
                         <?php if (hasAccess('add-teacher')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/teachers/add-teacher.php">
                                   Ajouter un enseignant
                              </a>
                         <?php endif; ?>

                         <?php if (hasAccess('list-teacher')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/teachers/list-teacher.php">
                                   Liste des enseignants
                              </a>
                         <?php endif; ?>
                    </nav>
               </li>
          <?php endif; ?>

          <!-- Gestion des parents -->
          <?php if (hasSectionAccess('parents')): ?>
               <li class="navigation__navigation-item navigation-item">
                    <h3 class="navigation-item__title">Gestion des parents</h3>
                    <nav class="navigation-item__subnavigation subnavigation">
                         <?php if (hasAccess('add-parent')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/parents/add-parent.php">
                                   Ajouter un parent
                              </a>
                         <?php endif; ?>

                         <?php if (hasAccess('list-parent')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/parents/list-parent.php">
                                   Liste des parents
                              </a>
                         <?php endif; ?>
                    </nav>
               </li>
          <?php endif; ?>

          <!-- Gestion des élèves -->
          <?php if (hasSectionAccess('students')): ?>
               <li class="navigation__navigation-item navigation-item">
                    <h3 class="navigation-item__title">Gestion des élèves</h3>
                    <nav class="navigation-item__subnavigation subnavigation">
                         <?php if (hasAccess('add-student')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/students/add-student.php">
                                   Inscrire un élève
                              </a>
                         <?php endif; ?>

                         <?php if (hasAccess('reinscription-student')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/students/reinscription-student.php">
                                   Réinscrire un élève
                              </a>
                         <?php endif; ?>

                         <?php if (hasAccess('list-student')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/students/list-student.php">
                                   Liste des élèves
                              </a>
                         <?php endif; ?>
                    </nav>
               </li>
          <?php endif; ?>

          <!-- Gestion des programmes -->
          <?php if (hasSectionAccess('schedules')): ?>
               <li class="navigation__navigation-item navigation-item">
                    <h3 class="navigation-item__title">Gestion des programmes</h3>
                    <nav class="navigation-item__subnavigation subnavigation">
                         <?php if (hasAccess('add-schedule')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/schedules/add-schedule.php">
                                   Ajouter un programme
                              </a>
                         <?php endif; ?>

                         <?php if (hasAccess('list-schedule')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/schedules/list-schedule.php">
                                   Liste des programmes
                              </a>
                         <?php endif; ?>

                         <?php if (hasAccess('generate-timetable')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/schedules/timetable/generate-timetable.php">
                                   Générer emploi du temps
                              </a>
                         <?php endif; ?>
                    </nav>
               </li>
          <?php endif; ?>

          <!-- Gestion de la scolarité -->
          <?php if (hasSectionAccess('scolarities')): ?>
               <li class="navigation__navigation-item navigation-item">
                    <h3 class="navigation-item__title">Gestion de la scolarité</h3>
                    <nav class="navigation-item__subnavigation subnavigation">
                         <?php if (hasAccess('list-scolarity')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/scolarities/list-scolarity.php">
                                   Liste des scolarités
                              </a>
                         <?php endif; ?>
                    </nav>
               </li>
          <?php endif; ?>

          <!-- Gestion des notes -->
          <?php if (hasSectionAccess('grades')): ?>
               <li class="navigation__navigation-item navigation-item">
                    <h3 class="navigation-item__title">Gestion des notes</h3>
                    <nav class="navigation-item__subnavigation subnavigation">
                         <?php if (hasAccess('order-grade')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/grades/order-grade.php">
                                   Ajouter des notes
                              </a>
                         <?php endif; ?>

                         <?php if (hasAccess('edit-list-grade')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/grades/edit-list-grade.php">
                                   Édition / Liste des notes
                              </a>
                         <?php endif; ?>

                         <?php if (hasAccess('generate-report-card')): ?>
                              <a class="subnavigation__subnavigation-item subnavigation-item"
                                   href="/gsc/backend/Views/pages/grades/report-card/generate-report-card.php">
                                   Générer les bulletins
                              </a>
                         <?php endif; ?>
                    </nav>
               </li>
          <?php endif; ?>

     </ul>
</div>
