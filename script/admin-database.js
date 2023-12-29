document.addEventListener('DOMContentLoaded', function() {
    var searchByDropdown = document.getElementById('search-by');
    var searchInput = document.getElementById('search');
    var searchLabel = document.getElementById('search-label');
    var searchButton = document.getElementById('search-button');

    searchByDropdown.addEventListener('change', function() {
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