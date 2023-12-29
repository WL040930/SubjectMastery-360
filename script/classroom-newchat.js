function toggleNewChatModal() {
    // Toggle the visibility of the modal with a fade-in/out animation
    var modal = document.getElementById('newChatContainer');
    modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
}

// Close the modal when the form is submitted
document.getElementById('newChatForm').addEventListener('submit', function (event) {
    event.preventDefault();
    document.getElementById('newChatContainer').style.display = 'none';
});