<?php
    include_once "sidebar.php";
?>

<!-- footer page -->
<div class="gsc-footer" id="dashboard-footer">
	<p class="text-footer">GSC-APP ayila.bour@gmail.com 2025</p>
</div>
</div>

<!-- Popup global -->
<div id="popup-overlay" class="popup-overlay hidden">
	<div id="popup-box" class="popup-box">
		<div id="popup-message" class="popup-content"></div>
		<span id="popup-close" class="popup-close">&times;</span>
	</div>
</div>

<!-- Popup confirmation -->
<div id="popup-confirm-overlay" class="popup-overlay hidden">
    <div class="popup-box">
        <div id="popup-confirm-message" class="popup-content"></div>
        <div class="popup-actions">
            <button id="popup-confirm-yes" class="btn btn-success">Oui</button>
            <button id="popup-confirm-no" class="btn btn-danger">Non</button>
        </div>
    </div>
</div>
</body>

</html>