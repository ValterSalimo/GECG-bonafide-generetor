document.addEventListener("DOMContentLoaded", function() {
    // Fetch username from session and display it
    var username = "<?php echo $_SESSION['username']; ?>";
    document.getElementById("username").innerText = username;

    // Fetch and display approval requests
    fetchApprovalRequests();

    // Event listener for the menu icon
    document.querySelector('.menu_icon_box').addEventListener('click', function() {
        this.classList.toggle('active');
    });

    // Event listener for the submit button
    document.getElementById("submitButton").addEventListener("click", function() {
        // Implement functionality to submit approval decisions
        // You can use AJAX or fetch to send data to the server
        // Example:
        // fetch('submit_approval.php', {
        //     method: 'POST',
        //     body: JSON.stringify(approvalDecisions),
        //     headers: {
        //         'Content-Type': 'application/json'
        //     }
        // })
        // .then(response => {
        //     // Handle response
        // })
        // .catch(error => {
        //     console.error('Error:', error);
        // });
    });

    // Function to fetch and display approval requests
    function fetchApprovalRequests() {
        fetch('fetch_approval_requests.php') // Adjust URL according to your server setup
            .then(response => response.json())
            .then(data => {
                // Process data and dynamically generate HTML to display approval requests
                var approvalRequestsHTML = "<table><tr><th>Request ID</th><th>Name</th><th>Enrollment Number</th><th>Purpose</th><th>Status</th><th>Action</th><th>Comment</th></tr>";
                data.forEach(row => {
                    approvalRequestsHTML += "<tr>";
                    approvalRequestsHTML += "<td>" + row.request_id + "</td>";
                    approvalRequestsHTML += "<td>" + row.name + "</td>";
                    approvalRequestsHTML += "<td>" + row.enrollment_number + "</td>";
                    approvalRequestsHTML += "<td>" + row.purpose + "</td>";
                    approvalRequestsHTML += "<td>" + row.status + "</td>";
                    approvalRequestsHTML += "<td><input type='radio' name='action[" + row.request_id + "]' value='approve'> Approve | <input type='radio' name='action[" + row.request_id + "]' value='reject'> Reject</td>";
                    approvalRequestsHTML += "<td><input type='text' name='comment[" + row.request_id + "]'></td>";
                    approvalRequestsHTML += "</tr>";
                });
                approvalRequestsHTML += "</table>";
                document.getElementById("approvalRequests").innerHTML = approvalRequestsHTML;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});
function validateEmail() {
    var email = document.getElementById('username').value;
    var emailPattern = /^[\w-]+@(gecg28\.ac\.in)$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address in the format: 210130107033@gecg28.ac.in');
        return false;
    }
    return true;
}