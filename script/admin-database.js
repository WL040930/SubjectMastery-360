document.addEventListener('DOMContentLoaded', function() {
    var searchByDropdown = document.getElementById('search-by');
    var searchInput = document.getElementById('search');
    var searchLabel = document.getElementById('search-label');
    var searchButton = document.getElementById('search-button');

    // Listen for changes in the dropdown
    searchByDropdown.addEventListener('change', function() {
        // Update the visibility and placeholder of the input field based on the selected option
        var selectedValue = this.value;
        
        if (selectedValue === 'username' || selectedValue === 'email') {
            searchLabel.style.display = 'block';
            searchButton.style.display = 'block';
            searchInput.placeholder = "Enter " + selectedValue;
        } else {
            searchLabel.style.display = 'none';
            searchButton.style.display = 'none';
        }
    });
});