document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    console.log('Username:', username);
    console.log('Password:', password);

    if (username === 'unagi' && password === 'alex') {
        alert('Logged in successfully!');
        // Update the redirection path if necessary
        window.location.href = 'dashboard.php';
    } else {
        alert('Invalid username or password. Please try again.');
    }
});



// function searchDatabase() {
//     var searchInput = document.getElementById('searchInput').value;

//     // Check if the search input is not empty
//     if (searchInput.trim() !== '') {
//         // Send the search input to the server (you'll need to implement this part)
//         // Example using fetch API
//         fetch('search.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify({ searchTerm: searchInput }),
//         })
//         .then(response => response.json())
//         .then(data => {
//             // Display the search results
//             displaySearchResults(data);
//         })
//         .catch(error => {
//             console.error('Error:', error);
//         });
//     }
// }

// function displaySearchResults(results) {
//     var searchResultsContainer = document.getElementById('searchResults');

//     // Clear previous results
//     searchResultsContainer.innerHTML = '';

//     if (results.length > 0) {
//         // Display each result
//         results.forEach(result => {
//             var resultElement = document.createElement('p');
//             resultElement.textContent = result.your_field; // Replace 'your_field' with your actual field name
//             searchResultsContainer.appendChild(resultElement);
//         });
//     } else {
//         // Display a message if no results were found
//         searchResultsContainer.textContent = 'No results found.';
//     }
// }
