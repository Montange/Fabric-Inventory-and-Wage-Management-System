// Show the confirmation dialog when logout is clicked
function showConfirmationDialog() {
    document.getElementById('dialogOverlay').style.display = 'flex';
}

// Hide the confirmation dialog when "No" is clicked
function hideConfirmationDialog() {
    document.getElementById('dialogOverlay').style.display = 'none';
}

// Perform the logout action when "Yes" is clicked
function logout() {
    window.location.href = 'logout.php';
}
