// Popup component use two importants params.
// First param is type of message and can take values : success or danger or warning
// Second param is message of popup
// Syntaxe : showPopup(type, message);
// Example : showPopup("success", "User added successfully");
// Example : showPopup("danger", "Failed to add user");
// Example : showPopup("warning", "Becurfull! User exit in data base");

// Popup confirm component use three importants params.
// First param is message of popup.
// Second param is an callback who return true .
// Three param is an callback who return false.
// Syntaxe : showConfirmPopup(message, onConfirm, onCancel);
/* Example :showConfirmPopup(
				"Are you sure to delete user ?",
				() => {
					try {
						const result = true;
						if (result) {
							showPopup("success", "message success");
						} else {
							showPopup("danger", "message danger");
						}
					} catch (e) {
						showPopup("danger", "server error.");
					}
				},
				() => {
					showPopup("warning", "Suppression annulée.");
				}
			);*/

let _autoCloseTimer = null;

function ensureOverlay() {
	let overlay = document.getElementById("popup-overlay");
	if (!overlay) {
		overlay = document.createElement("div");
		overlay.id = "popup-overlay";
		overlay.className = "popup-overlay hidden";
		overlay.innerHTML = `
            <div id="popup-box" class="popup-box">
            <div id="popup-message" class="popup-content"></div>
            <span id="popup-close" class="popup-close">&times;</span>
            </div>
        `;
		document.body.appendChild(overlay);
	}
	return {
		overlay,
		box: document.getElementById("popup-box"),
		messageBox: document.getElementById("popup-message"),
		closeBtn: document.getElementById("popup-close"),
	};
}

function hideOverlay(overlay) {
	overlay.classList.add("hidden");
	clearTimeout(_autoCloseTimer);
	_autoCloseTimer = null;
}

export function showPopup(type, text, autoClose = true) {
	const { overlay, box, messageBox, closeBtn } = ensureOverlay();

	box.className = `popup-box popup-${type}`;

	messageBox.className = `popup-content alerte alerte-${type}`;
	messageBox.innerHTML = `
    <p class="alerte__text">
        <span class="text">${text}</span>
        ${
			type === "success"
				? '<span class="check-color check-success">&check;</span>'
				: ""
		}
        ${
			type === "danger"
				? '<span class="check-color check-danger">&check;</span>'
				: ""
		}
        ${
			type === "warning"
				? '<span class="check-color check-warning">!</span>'
				: ""
		}
    </p>
    `;

	overlay.classList.remove("hidden");

	closeBtn.onclick = () => hideOverlay(overlay);
	overlay.onclick = (e) => {
		if (e.target === overlay) hideOverlay(overlay);
	};

	clearTimeout(_autoCloseTimer);

	if (autoClose) {
		_autoCloseTimer = setTimeout(() => hideOverlay(overlay), 5000);
	}
}

export function showConfirmPopup(message, onConfirm, onCancel) {
	const overlay = document.getElementById("popup-confirm-overlay");
	const msgBox = document.getElementById("popup-confirm-message");
	const yesBtn = document.getElementById("popup-confirm-yes");
	const noBtn = document.getElementById("popup-confirm-no");

	msgBox.innerHTML = `<p>${message}</p>`;
	overlay.classList.remove("hidden");

	yesBtn.onclick = () => {
		overlay.classList.add("hidden");
		if (typeof onConfirm === "function") onConfirm();
	};

	noBtn.onclick = () => {
		overlay.classList.add("hidden");
		if (typeof onCancel === "function") onCancel();
	};
}
