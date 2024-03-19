window.addEventListener('scroll', function(){
    var navbar = document.querySelector(".navbar");
    var banner = document.querySelector('.banner');
    var searchBar = document.querySelector('.search-bar');
    var rect = searchBar.getBoundingClientRect();
    navbar.classList.toggle("stick", window.scrollY > rect.bottom);
    navbar.classList.toggle("sticky", window.scrollY > 0);
    banner.classList.toggle("hidden", window.scrollY > rect.bottom);
});
function deleteCards() {
    // Gather the IDs of the members to be deleted
    var memberIds = $(".select-card:checked").map(function() {
        return $(this).data('memberid'); // Assuming each checkbox has a 'data-member-id' attribute
    }).get();

    // Send the array of IDs to 'removemember.php' via AJAX
    $.ajax({
        url: 'removemember.php', // The server-side script to process the deletion
        type: 'POST',
        data: { 'memberIds': memberIds }, // The data to send
        success: function(response) {
            // Handle the response from the server
            // If successful, remove the member elements from the page
            $(".select-card:checked").each(function() {
                $(this).closest('.column').remove();
            });
        },
        error: function(xhr, status, error) {
            // Handle any errors that occur during the request
            alert("Error: " + error);
        }
    });
}
$('.fa-user-plus').click(function() {
    $('html, body').animate({
      scrollTop: $('.addmember').offset().top-110
    }, 'slow');
    $('#memberForm').prop('action', 'addmember.php');
    $('#picture').attr('required', 'required');
    $('#studentid').prop('readonly', false);
});
$(document).ready(function(){
    $('#memberForm').submit(function(event){
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this); // Create a FormData object with form data
        var formAction = $(this).attr('action');
        $.ajax({
            url: formAction, // The file where you process the form
            type: 'POST',
            data: formData,
            contentType: false, // Required for 'multipart/form-data'
            processData: false, // Required for 'multipart/form-data'
            success: function(data){
                if(formAction == "addmember.php"){
                    var newMember = JSON.parse(data);
                    $('.row2').append(`
                        <div class="column">
                            <input type="checkbox" class="select-card" data-memberid="${newMember['studentid']}">
                            <div class="imgBox">
                                <img src="${newMember['image']}" alt="profile">
                            </div>
                            <div class="details">
                                <h3>${newMember['fname']}<br><span>${newMember['position']}</span></h3>
                                <ul>
                                    <li><a href="${newMember['facebook']}"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-google-plus-g"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    `)
                }else if(formAction == "editmember.php"){
                    var updatedMember = JSON.parse(data);
                    // Find the column with the matching 'data-memberid'
                    var memberColumn = $('.select-card[data-memberid="' + updatedMember['studentid'] + '"]').closest('.column');
                    // Update the column with the new details
                    memberColumn.find('img').attr('src', updatedMember['image']); // Update the image src
                    memberColumn.find('h3').html(updatedMember['fname'] + '<br><span>' + updatedMember['position'] + '</span>'); // Update the name and position
                    // Update social links and any other details as needed
                    memberColumn.find('a[href]').each(function(){
                        var socialClass = $(this).find('i').attr('class');
                        switch(socialClass) {
                            case 'fa-brands fa-facebook-f':
                            $(this).attr('href', updatedMember['facebook']);
                            break;
                        // Add cases for other social networks
                        }
                    });
                }
            },
            error: function(){
                // Handle errors here
                alert('There was an error submitting the form!');
            }
        });
    });
});
$('.fa-user-pen').click(function() {
    $('#memberForm').prop('action', 'editmember.php');
    $('#picture').removeAttr('required');
    var selectedCheckbox = $(".select-card:checked").first();
    if (selectedCheckbox.length) {
        var memberId = selectedCheckbox.data('memberid');
        // Make an AJAX call to fetch the member data from the database
        fetchMemberData(memberId);
        $('html, body').animate({
        scrollTop: $('.addmember').offset().top-110
      }, 'slow');
    } else {
        alert('Please select a member to edit.');
    }
});
function fetchMemberData(memberId) {
    $.ajax({
        url: 'getmemberdata.php', // The server-side script to fetch member data
        type: 'POST',
        data: { 'studentid': memberId },
        success: function(data) {
            var memberData = JSON.parse(data);
            populateForm(memberData);
        },
        error: function(xhr, status, error) {
            alert("Error fetching member data: " + error);
        }
    });
}
function populateForm(memberData) {
    $('#studentid').val(memberData.studentid).prop('readonly', true);
    $('#fname').val(memberData.fname);
    $('#major').val(memberData.major);
    $('#grade').val(memberData.grade);
    $('#name').val(memberData.name);
    $('#position').val(memberData.position);
    $('#bio').val(memberData.bio);
    $('#facebook').val(memberData.facebook);
    $('#email').val(memberData.email);
    //$('#memberForm').find('button[type="submit"]').text('Update Member');
}