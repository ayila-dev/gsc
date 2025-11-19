<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GSC - report-card grades</title>
    <link rel="stylesheet" href="/gsc/public/assets/css/report-card.css" />
    <script src="/gsc/public/assets/js/crud.js" defer></script>
    <script src="/gsc/public/assets/js/api-crud.js" type="module" defer></script>
    <script src="/gsc/public/assets/js/main.js" type="module" defer></script>
</head>
<body data-page="report-card"
      data-level-id="1"
      data-serie-id="1"
      data-room-id="1"
      data-place-id="1"
      data-period="t1">

<div class="report-card">

    <!-- ==================== HEADER ==================== -->
    <table class="report-card__header">
        <div class="report-card__head">
            <div class="report-card__enseigne">
                <img src="../../../../../public/assets/images/gsc-logo.png"
                     alt="logo de l'école"
                     class="report-card__school-logo" />

                <ul class="report-card__infos">
                    <li class="infos__item">REPUBLIQUE DU BÉNIN</li>
                    <li class="infos__item">MINISTÈRE DES ENSEIGNEMENTS SECONDAIRE ET DE LA FORMATION PROFESSIONNELLE</li>
                    <li class="infos__item">DIRECTION DE L'ENSEIGNEMENT GÉNÉRAL</li>
                    <li class="infos__item">CONTACT : 20 21 43 18</li>
                </ul>
            </div>

            <h1 class="report-card__header-title">BULLETIN DES NOTES</h1>
        </div>

        <tr class="report-card__row">
            <th class="report-card__col">MATRICULES :</th>
            <td class="report-card__col" id="rc-matricule">.....</td>
            <th class="report-card__col">ANNÉE SCOLAIRE :</th>
            <td class="report-card__col" id="rc-year">.....</td>
        </tr>

        <tr class="report-card__row">
            <th class="report-card__col">NOM et PRÉNOMS :</th>
            <td class="report-card__col" id="rc-fullname">.....</td>
            <th class="report-card__col">CLASSE :</th>
            <td class="report-card__col" id="rc-class">.....</td>
        </tr>

        <tr class="report-card__row">
            <th class="report-card__col">DATE DE NAISSANCE :</th>
            <td class="report-card__col" id="rc-birthdate">.....</td>
            <th class="report-card__col">SEMESTRE :</th>
            <td class="report-card__col" id="rc-semester">.....</td>
        </tr>

        <tr class="report-card__row">
            <th class="report-card__col">EFFECTIF :</th>
            <td class="report-card__col" id="rc-total">.....</td>
			<th class="report-card__col">SEXE :</th>
            <td class="report-card__col id="rc-gender">.....</td>
        </tr>
    </table>

    <!-- ==================== BODY (notes) ==================== -->
    <table class="report-card__body">
        <tr class="report-card__row">
            <th class="report-card__col">MATIÈRES</th>
            <th class="report-card__col">COEF</th>
            <th class="report-card__col">INT 1</th>
            <th class="report-card__col">INT 2</th>
            <th class="report-card__col">INT 3</th>
            <th class="report-card__col">MOY INT</th>
            <th class="report-card__col">DEV 1</th>
            <th class="report-card__col">DEV 2</th>
            <th class="report-card__col">MOY MATIÈRE</th>
            <th class="report-card__col">MOY COEF</th>
            <th class="report-card__col">RANG</th>
            <th class="report-card__col" style="border-right: 0.1rem solid var(--primary)">APRÉCIATION</th>
        </tr>

        <!-- Lignes des matières à remplir automatiquement -->

    </table>

    <!-- ==================== FOOTER (stats) ==================== -->
    <table class="report-card__footer-start">
        <tr class="report-cart__row">
            <td class="report-card__col">
                <h2>SEMESTRE 1</h2>
                <p id="moy-sem1">Moyenne : ......</p>
                <p id="rang-sem1">Rang : ......</p>
                <p id="hight-moy-sem1">Forte Moyenne : ......</p>
                <p id="low-moy-sem1">Faible Moyenne : ......</p>
            </td>

            <td class="report-card__col">
                <h2>SEMESTRE 2</h2>
                <p id="moy-sem2">Moyenne : ......</p>
                <p id="rang-sem2">Rang : ......</p>
                <p id="hight-moy-sem2">Forte Moyenne : ......</p>
                <p id="low-moy-sem2">Faible Moyenne : ......</p>
            </td>

            <td class="report-card__col">
                <h2>BILAN ANNUEL</h2>
                <p id="moy">Moyenne Annuelle : ......</p>
                <p id="rang">Rang Annuelle : ......</p>
                <p id="hight-moy">Forte Moyenne : ......</p>
                <p id="low-moy">Faible Moyenne : ......</p>
            </td>
        </tr>
    </table>

    <!-- ==================== FOOTER DECISIONS ==================== -->
    <table class="report-card__footer-end">
        <tr class="report-cart__row">
            <th class="report-card__col" colspan="2">Décision du conseil des prof</th>
            <th class="report-card__col" colspan="2">Discipline</th>
            <th class="report-card__col">Observation du Directeur</th>
        </tr>
        <tr class="report-cart__row">
            <td class="report-card__col"><label for="pass">Passe en classe supérieure</label></td>
            <td class="report-card__col check"><input type="checkbox" id="pass" /></td>
            <td class="report-card__col">Nombre de Retard :</td>
            <td class="report-card__col check">...</td>
            <td class="report-card__col" rowspan="7"><center>.....</center></td>
        </tr>

        <tr class="report-cart__row">
            <td class="report-card__col"><label for="red">Redouble (en cas d'échec)</label></td>
            <td class="report-card__col check"><input type="checkbox" id="red" /></td>
            <td class="report-card__col">Nombre d'Abscence :</td>
            <td class="report-card__col check">...</td>
        </tr>

        <tr class="report-cart__row">
            <td class="report-card__col"><label for="exclu">Exclu(e)</label></td>
            <td class="report-card__col check"><input type="checkbox" id="exclu" /></td>
            <td class="report-card__col">Consignes (Heures) :</td>
            <td class="report-card__col check">...</td>
        </tr>

        <tr class="report-cart__row">
            <td class="report-card__col"><label for="avtTrav">Avertissement (travail)</label></td>
            <td class="report-card__col check"><input type="checkbox" id="avtTrav" /></td>
            <td class="report-card__col">Exclusions (Jours) :</td>
            <td class="report-card__col check">...</td>
        </tr>

        <tr class="report-cart__row">
            <td class="report-card__col"><label for="tableau">Tableau d'honneur</label></td>
            <td class="report-card__col check"><input type="checkbox" id="tableau" /></td>
            <td class="report-card__col">Avertissement (Conduite) :</td>
            <td class="report-card__col check">...</td>
        </tr>

        <tr class="report-cart__row">
            <td class="report-card__col"><label for="encour">Encouragements</label></td>
            <td class="report-card__col check"><input type="checkbox" id="encour" /></td>
            <td class="report-card__col" rowspan="2">Blâme (Conduite) :</td>
            <td class="report-card__col check" rowspan="2">...</td>
        </tr>

        <tr class="report-cart__row">
            <td class="report-card__col"><label for="fel">Félicitations</label></td>
            <td class="report-card__col check"><input type="checkbox" id="fel" /></td>
        </tr>
    </table>

</div>

</body>
</html>
