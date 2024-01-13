<?php
// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 1 if you want errors to be displayed on the page
ini_set('log_errors', 1);
ini_set('error_log', 'error.log'); // Adjust the filename and path as needed

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
<!-- Latest version of Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest version of jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Latest version of Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

<!-- Latest version of Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            padding-top: 56px;
        }

        .content {
            padding: 20px;
        }

.add-choice-btn {
    margin-left: 10px;
}
#flowchartSection {
  margin-top: 20px;
  padding: 20px;
  border: 1px solid #ccc;
}

#flowchartContainer {
  width: 100%;
  height: 400px; /* Adjust the height as needed */
  border: 1px solid #ddd;
}

    </style>
<script>
// Define constants for URLs
const FETCH_SELECTED_BOOK_URL = '/book/admin-portal/books/fetch-selected-book.php';
const FETCH_SELECTED_BOOK_PREFERENCES_URL = '/book/admin-portal/books/fetch-selected-book-preferences.php';
//const FETCH_SELECTED_BOOK_CHAPTERS_URL = '/book/admin-portal/books/fetch-selected-book-chapters.php';
const FETCH_SELECTED_BOOK_PAGES_URL = '/book/admin-portal/books/fetch-selected-book-pages.php';
const SCRIPT_PATH_URL = '/book/admin-portal/books/';
function loadContent(section) {
        // Hide all sections
        $('#home, #userManagement, #newsManagement, #bookManagement').hide();

        // Load content based on the clicked link
        switch (section) {
            case 'home':
                $('#home').show();
                break;
            case 'user-management':
                $('#userManagement').show();
                break;
            case 'news-management':
                $('#newsManagement').show();
                break;
            case 'book-management':
                $('#bookManagement').show();
                break;
            default:
                break;
        }
    }

//////////////////////////////BOOK MANAGEMENT/////////////////////////////////////////////
// Declare selectedBookId as a global variable
// Global variable for choice counter
var choiceCounter = 0;
var selectedBookId;
var selectedPageId;
var amountOfChoices; 
var selectedChapterId;

///////LATEST FUNCTIONS/////////////////////////////////////////////
///////////////////////////////////////////////////////////////////

// Global variable to store the book data
let bookData;

// Function to fetch all book data
async function fetchAllBookData(bookId) {
    const response = await fetch(`/book/admin-portal/books/fetch-all-book-data.php?book_id=${bookId}`);
    const data = await response.json();

    if (response.ok) {
        return data;
    } else {
        throw new Error(data.error);
    }
      // Log the bookData
      console.log('Current book data:', data);
}

// Function to fetch choices for a page
async function fetchChoices(pageId) {
    const response = await fetch(`/book/admin-portal/books/fetch-choices.php?page_id=${pageId}`);
    const data = await response.json();

    console.log('fetchChoices: fetchChoices response data:', data); // Log the response data

    if (response.ok) {
        // Convert the data to an array of choices
        const choices = [];
        const choicesData = data[0]; // Access the first element of the data array
        const amountOfChoices = choicesData.amount_of_choices; // Get the amount of choices
        for (let i = 1; i <= amountOfChoices; i++) { // Loop over all possible choices
            choices.push({
                choiceId: choicesData.choice_id, // Include the choice_id
                [`choice_text_${i}`]: choicesData[`choice_text_${i}`] || null, // Use null if the choice doesn't exist
                [`target_page_${i}`]: choicesData[`target_page_${i}`] || null // Use null if the target page doesn't exist
            });
        }
        console.log('fetchChoices: fetchChoices choices:', choices); // Log the choices
        return choices;
    } else {
        throw new Error(data.error);
    }
}

// Function to fetch and display choices for a page associated with a given choiceId
async function fetchAndDisplayChoices(choiceId) {
// Fetch the pageId associated with the choiceId
const pageId = await fetchPageId(choiceId);
console.log('Page ID:', pageId); // Log the pageId

// Fetch the choices for the page
const choices = await fetchChoices(pageId);

// Display the choices
displayChoices(choices, pageId);
}

// Function to load all book data at once
function loadAllBookData(bookId) {
    console.log(`Loading data for bookId: ${bookId}`); // Log the bookId being loaded

    fetchAllBookData(bookId)
        .then((fetchedData) => {
            console.log('Received book data:', fetchedData); // Log the received book data

            // Store the fetched book data
            bookData = fetchedData;

            if (bookData) {
                // Update the selectedBookId after the AJAX call is complete
                selectedBookId = bookId;

                // Extract different sections of data
                const bookDetails = bookData.book; 
                const bookPreferences = bookData.book_preferences;
                const bookChapters = bookData.chapters;
                const choiceAmount = bookData.choice_amount; // Extract the choice amount

                console.log('Choice amount:', choiceAmount); // Log the choice amount

                // Clear existing content and display data
                clearBookDetailsTable();
                displayBookDetails(bookDetails);
                showBookDetailsSection();

            
                clearChaptersList();
                displayChaptersList(bookId);
               
            }
        })
        .catch((error) => {
            console.error('Error loading book data:', error);
        });
}

// Function to display chapters in the list
function displayChaptersList(bookId) {
    // Fetch the chapters for the selected book
    const chapters = bookData.chapters.filter(chapter => chapter.book_id == bookId);

    // Fetch the pages for the selected book
    const pages = bookData.pages;

    // Clear the chapters container
    const chaptersContainer = document.getElementById('chaptersContainer');
    chaptersContainer.innerHTML = '';

    // Add each chapter to the chapters container
    for (const chapter of chapters) {
        addChapterDetailsCollapse(chapter, pages);
    }
}

// Function to add collapsible div for chapter details
function addChapterDetailsCollapse(chapter, pages) {
    //console.log('addChapterDetailsCollapse is being called with chapter:', chapter);

    // Create a card for each chapter
    var chapterCard = '<div class="card">' +
        '<div class="card-header">' +
        '<a class="collapsed btn chapter-accordion" data-bs-toggle="collapse" href="#chapterCollapse_' + chapter.chapter_id + '">' +
        'Chapter ' + chapter.chapter_number +
        '</a>' +
        '</div>' +
        '<div class="collapse" id="chapterCollapse_' + chapter.chapter_id + '">' +
        '<div class="card card-body">' +
        // Add any additional chapter details or form elements here
        'Chapter Affinity: ' + chapter.affinity_requirement + '<br>' +
        'Chapter Content: ' + chapter.storyline +
        // Add a placeholder for the pages accordion
        '<div id="pagesAccordion_' + chapter.chapter_id + '"></div>' +
        '</div>' +
        '</div>' +
        '</div>';

    // Append the chapter card to the chapters container
    document.getElementById('chaptersContainer').innerHTML += chapterCard;

    // Check if pages is defined and is an array before calling displayPagesAndChoicesInAccordion
    if (Array.isArray(pages)) {
        // Display pages and choices in the accordion
        displayPagesAndChoicesInAccordion(chapter.chapter_id, pages);
    } else {
        console.error('Pages is not defined or is not an array:', pages);
    }
}

// Function to display pages and choices in the accordion
function displayPagesAndChoicesInAccordion(chapterId, pages) {
    console.log('Entering displayPagesAndChoicesInAccordion function with chapterId:', chapterId, 'and pages:', pages);

    // Clear existing pages accordion
    var pagesAccordion = document.getElementById('pagesAccordion_' + chapterId);
    pagesAccordion.innerHTML = '';

    // Filter pages for the current chapter
    var chapterPages = pages.filter(page => page.chapter_id === chapterId);
    console.log('Chapter pages:', chapterPages); // Log the chapter pages

    // Check if chapterPages is defined
    if (chapterPages && chapterPages.length > 0) {
        // Iterate through pages and create the pages accordion
        for (let i = 0; i < chapterPages.length; i++) {
            const page = chapterPages[i];
            console.log('Page:', page); // Log the current page

            // Set bookData.currentPage to the index of the current page in bookData.pages
            bookData.currentPage = bookData.pages.findIndex(bookPage => bookPage.page_id === page.page_id);

            // Filter choices for the current page
            var pageChoices = bookData.choices.filter(choice => choice.page_id === page.page_id);
            console.log('Page choices:', pageChoices); // Log the page choices

            // Create a list of choices
            var choicesList = document.createElement('ul');
            choicesList.id = 'choicesList' + page.page_id;

            // Create a card for each page
            var pageCard = document.createElement('div');
            pageCard.className = 'card';

            var cardHeader = document.createElement('div');
            cardHeader.className = 'card-header';

            var pageAccordion = document.createElement('a');
            pageAccordion.className = 'collapsed btn page-accordion';
            pageAccordion.dataset.bsToggle = 'collapse';
            pageAccordion.href = '#pageCollapse_' + page.page_id;
            pageAccordion.textContent = 'Page ' + page.page_number;

            cardHeader.appendChild(pageAccordion);
            pageCard.appendChild(cardHeader);

            var collapseDiv = document.createElement('div');
            collapseDiv.className = 'collapse';
            collapseDiv.id = 'pageCollapse_' + page.page_id;

            var cardBody = document.createElement('div');
            cardBody.className = 'card card-body';
            cardBody.innerHTML = 'Page Content: ' + page.content;
            cardBody.appendChild(choicesList);

            collapseDiv.appendChild(cardBody);
            pageCard.appendChild(collapseDiv);

            // Append the page card to the pages accordion
            pagesAccordion.appendChild(pageCard);

            // Display choices after the choices list element is in the DOM
            displayChoices(pageChoices, page.page_id);
        }
    } else {
        // Display a message if no pages are available for the chapter
        pagesAccordion.innerHTML += '<p>No pages available for this chapter.</p>';
    }
    console.log('Exiting displayPagesAndChoicesInAccordion function');
}

// Function to display choices
function displayChoices(choices, pageId) {
    var choicesList = document.getElementById('choicesList' + pageId);
     // Check if choicesList is null
     if (!choicesList) {
        console.error('Element with id "choicesList' + pageId + '" not found');
        return;
    }

    choicesList.innerHTML = '';

    console.log('Choices:', choices); // Log the choices

    // Iterate over the choices
    for (let i = 0; i < choices.length; i++) {
        const choice = choices[i];

        console.log('Choice:', choice); // Log the current choice

        // Iterate over the choice texts and target pages
        for (let j = 1; j <= 4; j++) {
            if (choice['choice_text_' + j] && choice['target_page_' + j]) {
                var choiceItem = document.createElement('li');
                choiceItem.className = 'list-group-item choice-item';
                choiceItem.dataset.targetPage = choice['target_page_' + j];
                choiceItem.dataset.choiceId = choice.choice_id;
                choiceItem.dataset.choiceNumber = j;
                choiceItem.textContent = choice['choice_text_' + j];

                choicesList.appendChild(choiceItem);
            }
        }
    }

    // If no choices exist for this page, display a message
    if (choices.length === 0) {
        var noChoiceItem = document.createElement('li');
        noChoiceItem.className = 'list-group-item';
        noChoiceItem.textContent = 'No choices for this page';
        choicesList.appendChild(noChoiceItem);
    }

    // Add event listener to open modal on choice click
    choicesList.querySelectorAll('.choice-item').forEach(item => {
        item.addEventListener('click', function() {
            var targetPage = this.dataset.targetPage;
            var choiceText = this.textContent;
            var choiceId = this.dataset.choiceId; // Get the choiceId from the dataset
            var choiceNumber = this.dataset.choiceNumber; // Get the choiceNumber from the dataset
            openEditChoiceModal(targetPage, choiceText, choiceId, choiceNumber); // Pass choiceId and choiceNumber to the function
        });
    });

    // Add "Add Choice" button
    var addButton = document.createElement('button');
    addButton.className = 'btn btn-success add-choice-btn';
    addButton.dataset.pageId = pageId;
    addButton.textContent = 'Add Choice';
    choicesList.appendChild(addButton);

    // Add event listener to open modal on "Add Choice" button click
    addButton.addEventListener('click', function() {
        var pageId = this.dataset.pageId;
        openAddChoiceModal(pageId);
    });
}

// Function to open the Edit Choice modal
function openEditChoiceModal(targetPage, choiceText, choiceId, choiceNumber, pageId) {
    console.log('Opening Edit Choice Modal with data:', {targetPage, choiceText, choiceId, choiceNumber});

    // Populate the modal fields with the current choice details
    var editedChoiceText = document.getElementById('editedChoiceText');
    if (editedChoiceText) {
        editedChoiceText.value = choiceText;
    } else {
        console.error('Element with ID "editedChoiceText" not found');
        return;
    }

    // Open the modal
    var editChoiceModalElement = document.getElementById('editChoiceModal');
    if (!editChoiceModalElement) {
        console.error('Element with ID "editChoiceModal" not found');
        return;
    }
    var editChoiceModal = new bootstrap.Modal(editChoiceModalElement);
    editChoiceModal.show();

    // Check if the Delete button already exists
    var deleteButton = document.getElementById('deleteEditedChoice');
    if (!deleteButton) {
        // Create the Delete button
        deleteButton = document.createElement('button');
        deleteButton.id = 'deleteEditedChoice';
        deleteButton.className = 'btn btn-danger';
        deleteButton.textContent = 'Delete Choice';

        // Append the Delete button to the modal footer
        var modalFooter = document.getElementById('editChoiceModalFooter');
        if (modalFooter) {
            modalFooter.appendChild(deleteButton);
            // Store the pageId in a data attribute of the delete button
            deleteButton.dataset.pageId = pageId;
        } else {
            console.error('Modal footer not found');
        }
    }

    // Define the event handlers
    var saveHandler = function() {
        // Get the updated choiceText
        var updatedChoiceText = editedChoiceText.value;

        console.log('Saving edited choice:', {choiceId, updatedChoiceText, targetPage, choiceNumber});

        // Save the edited choice
        saveEditedChoice(choiceId, updatedChoiceText, targetPage, choiceNumber);

        // Close the modal
        editChoiceModal.hide();
    };

    var cancelHandler = function() {
        console.log('Cancel button clicked');

        // Close the modal
        editChoiceModal.hide();
    };

    var deleteHandler = function() {
    console.log('Delete button clicked');

    console.log(`Deleting choice with choiceId: ${choiceId}, choiceNumber: ${choiceNumber}`);

    // Delete the choice
    deleteChoice(choiceId, choiceNumber, bookData.currentPage)
    .then(response => {
            console.log('Choice deleted successfully', response);
        })
        .catch(error => {
            console.error('Error deleting choice', error);
        });

    // Close the modal
    editChoiceModal.hide();
    };

    // Add event listener to the "Save" button
    var saveEditedChoiceButton = document.getElementById('saveEditedChoice');
    if (saveEditedChoiceButton) {
        saveEditedChoiceButton.addEventListener('click', saveHandler);
    } else {
        console.error('Element with ID "saveEditedChoice" not found');
    }

    // Add event listener to the "Cancel" button
    var cancelEditedChoice = document.getElementById('cancelEditedChoice');
    if (cancelEditedChoice) {
        cancelEditedChoice.addEventListener('click', cancelHandler);
    } else {
        console.error('Element with ID "cancelEditedChoice" not found');
    }

    // Add event listener to the "Delete" button
    deleteButton.addEventListener('click', deleteHandler);

    // Remove the event listeners and the Delete button when the modal is closed
    editChoiceModalElement.addEventListener('hidden.bs.modal', function () {
        if (saveEditedChoiceButton) {
            saveEditedChoiceButton.removeEventListener('click', saveHandler);
        }
        if (cancelEditedChoice) {
            cancelEditedChoice.removeEventListener('click', cancelHandler);
        }
        deleteButton.removeEventListener('click', deleteHandler);
        deleteButton.remove();
    });
}

async function deleteChoice(choiceId, choiceNumber) {
    try {
        // Delete the choice
        let response = await fetch(`/book/admin-portal/books/delete-choice.php`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ choice_id: choiceId, choice_number: choiceNumber })
});
        // Check if the response is ok
        if (!response.ok) {
            console.error('Error deleting choice:', response.statusText);
            return;
        }

        let responseData = await response.json();

        // Handle success
        if (responseData.message) {
            console.log('Choice deleted successfully:', responseData.message);
            alert('Choice deleted successfully'); // Show an alert

            // Refresh bookData
            bookData = await fetchAllBookData(selectedBookId);

            // Display the updated choices
            if (bookData.choices.length > 0) {
                displayChoices(bookData.choices);
            } else {
                console.error('Cannot display choices: No choices found for current page');
            }
        }
    } catch (error) {
        console.error('Error deleting choice:', error);
    }
}

// Function to save the edited choice
async function saveEditedChoice(choiceId, updatedChoiceText, targetPage, choiceNumber) {
    
    // Fetch the latest book data
    bookData = await fetchAllBookData(selectedBookId);
    // Create the data to send in the POST request
    var data = {
        choiceId: choiceId,
        choiceText: updatedChoiceText,
        choiceNumber: choiceNumber
    };
    //console.log('Sending data:', data);
    // Send the POST request
    try {
        const response = await fetch('/book/admin-portal/books/save-edited-choice.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const responseData = await response.json();
        //console.log('Response data:', responseData);
        if (responseData.message) {
            // Show a success alert
            alert(responseData.message);

            // Fetch the updated choices
            let currentPageId = bookData.pages[bookData.currentPage].page_id;
            let currentPageChoices = await fetchChoices(currentPageId);
            console.log('saveEditedChoice: Fetched updated choices:', currentPageChoices);

            // Display the updated choices
            if (currentPageChoices.length > 0) {
                displayChoices(currentPageChoices, currentPageId);
            } else {
                console.error('Cannot display choices: No choices found for current page');
            }
        } else if (responseData.error) {
            // Show an error alert
            alert(responseData.error);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Define the event listener function
let saveChoiceEventListener;

// Function to open the Add Choice modal
function openAddChoiceModal(pageId) {
    // Get the input field
    var choiceTextInput = document.getElementById('choiceText');

    // Check if the input field exists
    if (choiceTextInput) {
        // Set the value of the input field
        choiceTextInput.value = '';

        // Calculate the choice number
        var choiceNumber = calculateChoiceNumber(pageId);

        // Set the value of the choice number input field
        var choiceNumberInput = document.getElementById('choiceNumber');
        if (choiceNumberInput) {
            choiceNumberInput.type = 'hidden';
            choiceNumberInput.value = choiceNumber;
        } else {
            console.error('Choice number input field not found');
        }

        // Calculate the targetPage
        var targetPage = pageId + 1;

        // Add an event listener to the Save button
        var saveButton = document.getElementById('saveChoiceButton');
        if (saveButton) {
            // Remove the existing event listener
            if (saveChoiceEventListener) {
                saveButton.removeEventListener('click', saveChoiceEventListener);
            }

            // Define the new event listener
            saveChoiceEventListener = function() {
                console.log('Event listener triggered');
                saveNewChoice(choiceTextInput.value, pageId, targetPage);
                $('#addChoiceModal').modal('hide');
            };

            // Add the new event listener
            saveButton.addEventListener('click', saveChoiceEventListener);
        } else {
            console.error('Save button not found');
        }

        // Log the pageId, choiceText, and choiceNumber
        console.log('openAddChoiceModal:', 'pageId:', pageId, 'choiceText:', choiceTextInput.value, 'choiceNumber:', choiceNumber);

        // Show the modal
        $('#addChoiceModal').modal('show');
    } else {
        console.error('Choice text input field not found');
    }
}

// Function to calculate the choice number
function calculateChoiceNumber(pageId) {
    // Convert pageId to a string
    var pageIdString = String(pageId);

    // Get the choices for the current page
    var choices = bookData.choices.filter(choice => choice.page_id === pageIdString);

    // Check if any choices were found
    if (choices.length > 0) {
        // Return the number of choices
        return choices.length;
    } else {
        //console.error('No choices found for this page');
        return 0;
    }
}

async function saveNewChoice(choiceText, currentPageId, targetPage) {

     // Fetch the latest book data
     bookData = await fetchAllBookData(selectedBookId);

    console.log('saveNewChoice called with:', 'choiceText:', choiceText, 'currentPageId:', currentPageId, 'targetPage:', targetPage);

    // Validate the choice text
    if (!choiceText || choiceText.trim() === '') {
        alert('Choice text cannot be empty.');
        return;
    }
    var currentPageIdString = String(currentPageId);
    const currentChoiceData = bookData.choices.find(choice => choice.page_id === currentPageIdString);

    if (!currentChoiceData) {
        console.error('Choice not found for pageId:', currentPageIdString);
        return;
    }

   // Find the first null or empty choice
   let choiceIndex = null;
    for (let i = 1; i <= 4; i++) {
        if (currentChoiceData[`choice_text_${i}`] === null || currentChoiceData[`choice_text_${i}`] === '') {
            currentChoiceData[`choice_text_${i}`] = choiceText;
            console.log(`Set choice_text_${i} to:`, choiceText);
            choiceIndex = i;
            break;
        }
    }

    // If all choices are filled, alert the user
    if (choiceIndex === null) {
        alert('This page already has the maximum number of choices.');
        return;
    }

    currentChoiceData[`target_page_${choiceIndex}`] = targetPage;
    console.log(`Set target_page_${choiceIndex} to:`, targetPage);

    var data = {
        choiceId: currentChoiceData.choice_id,
        choiceIndex: choiceIndex,
        choiceText: choiceText,
        targetPage: targetPage
    };

    console.log('POST data:', data);

    try {
        const response = await fetch('/book/admin-portal/books/add-new-choice.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const responseData = await response.json();
        console.log('Response data:', responseData);
        if (responseData.message) {
            alert(responseData.message);
            let currentPageChoices = await fetchChoices(currentPageId);
            if (currentPageChoices.length > 0) {
                displayChoices(currentPageChoices, currentPageId);
            } else {
                console.error('Cannot display choices: No choices found for current page');
            }
        } else if (responseData.error) {
            alert(responseData.error);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}


////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

// Function to display book details in the editable table
function displayBookDetails(bookDetails) {
    // Check if book details are not null or undefined
    if (bookDetails !== null && bookDetails !== undefined) {
        // Get the table body
        const tableBody = document.getElementById('bookDetailsTableBody');

        // Iterate through book details and append columns to the row
        for (const key in bookDetails.book_details) {
            // Exclude the book_id field from being displayed
            if (key !== 'book_id') {
                // Create input fields for editing
                let inputField;
                const inputId = key; // Generate a unique ID for each input field

                if (key === 'book_size') {
                    // Create a dropdown for Book Size
                    inputField = document.createElement('select');
                    inputField.className = 'form-control';
                    inputField.id = inputId;
                    inputField.name = key;

                    ['Small', 'Normal', 'Large'].forEach(size => {
                        const option = document.createElement('option');
                        option.value = size;
                        option.text = size;
                        inputField.appendChild(option);
                    });
                } else {
                    inputField = document.createElement('input');
                    inputField.type = 'text';
                    inputField.className = 'form-control';
                    inputField.id = inputId;
                    inputField.value = bookDetails.book_details[key];
                    inputField.name = key;
                }

                // Create a row for book details with input fields
                const detailsRow = document.createElement('tr');
                detailsRow.className = 'table-active';

                const keyCell = document.createElement('td');
                keyCell.textContent = key;

                const valueCell = document.createElement('td');
                valueCell.appendChild(inputField);

                detailsRow.appendChild(keyCell);
                detailsRow.appendChild(valueCell);

                // Append the row to the table
                tableBody.appendChild(detailsRow);
            }

            // Update the hidden input field with the book ID
            document.getElementById('bookDetailsBookId').value = bookDetails.book_details.book_id;
        }
    } else {
        console.error('Received null or undefined book details from the server.');
    }
}

// Function to load chapters list for the selected book
function loadChaptersList(selectedBookId) {
    // Fetch all book data and display relevant sections
    loadAllBookData(selectedBookId)
        .then(({ bookChapters }) => {
            console.log(document.getElementById('bookChaptersBookId').value);
            console.error('bookid 2: and sel', bookId, selectedBookId);
            displayChaptersList(bookChapters);
        })
        .catch(function (error) {
            console.error('Error loading book data:', error);
        });
}

// Function to show Edit sections
function showEditSections(bookId) {
    hideBookListSection();
    showSections(['bookDetailsSection']); // Removed 'chapterListSection'

    // Ensure that bookId is valid before proceeding
    if (bookId !== null && bookId !== undefined) {
        loadAllBookData(bookId);
    } else {
        console.error('Invalid book ID:', bookId);
    }
}

// Function to clear the chapters list
function clearChaptersList() {
    document.getElementById('chaptersContainer').innerHTML = '';
}

// Function to display pages in the accordion
function displayPagesInAccordion(chapterId) {
    if (!bookData) {
        console.error('Book data is not loaded yet');
        return;
    }
    var pagesList = $('#pagesAndChoicesList' + chapterId);
    pagesList.empty();
    var bookId = bookData.book.book_id;

    // Fetch the pages for the selected chapter
    const pages = bookData.pages.filter(page => page.chapter_id == chapterId);

    if (pages && pages.length > 0) {
        // Append each page to the list
        $.each(pages, function (index, page) {
            // Construct the HTML for each page with an expandable textarea, input fields, a save button, and an "Add Choice" button
            var pageItem = '<li class="list-group-item">' +
                '<button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#pageCollapse' + page.page_id + '" aria-expanded="false" aria-controls="pageCollapse' + page.page_id + '">' +
                'Page Id: ' + page.page_id + ' : ' + ' Choice Id: ' + page.choice_id + '</button>' +
                // Add hidden input for chapter_id
                '<input type="hidden" id="chapterIdInput' + page.page_id + '" value="' + chapterId + '">' +
                '<div class="btn-group ms-auto">' +
                '<button class="btn btn-danger delete-page-btn" data-page-id="' + page.page_id + '" data-chapter-id="' + chapterId + '">Delete Page</button>' +
                '</div>' +
                '</li>';

            pagesList.append(pageItem);

            // Create a collapse for each page with an expandable textarea, input fields, a save button, and a placeholder for choices
            var pageCollapse = '<div class="collapse" id="pageCollapse' + page.page_id + '">' +
                '<div class="card card-body">' +
                'Content: <textarea id="contentInput' + page.page_id + '" class="form-control" rows="4">' + page.content + '</textarea><br>' +
                'Choices: <ul id="choicesList' + page.page_id + '" class="list-group"></ul>' +
                '<button class="btn btn-success" onclick="savePageChanges(' + page.page_id + ',' + chapterId + ')">Save Changes</button>' +
                '</div>' +
                '</div>';

            pagesList.append(pageCollapse);

            loadChoicesForPage(bookId, chapterId, page.page_id, function(choices, pageId, chapterId, bookId, choiceIds, choiceCount) {
                displayChoices(choices, pageId, chapterId, choiceCount);
            });
        });
    } else {
        pagesList.append('<li class="list-group-item">No pages available for this chapter.</li>');
    }
}



// Function to show book list and hide other sections
function showBookList() {
    hideSections(['bookDetailsSection']);
    showSections(['bookListSection']);
}

// Load books full details
async function loadBookData(bookId) {
    try {
        let bookDetails = await fetchSelectedBook(bookId);
        clearBookDetailsTable();
        displayBookDetails(bookDetails);
        showBookDetailsSection();

        let bookPreferences = await fetchSelectedBookPreferences(bookId);
        clearBookPreferencesTable();
        displayBookPreferences(bookPreferences);

        let bookChapters = await fetchSelectedBookChapters(bookId);
        
        displayBookChapters(bookChapters, bookId);
    } catch (error) {
        console.error('Error loading book data:', error);
    }
}

// Load pages for a chapter
async function loadPagesForChapter(bookId, chapterId) {
    try {
        let pages = await fetchSelectedBookPages(bookId, chapterId);
        displayPages(pages, chapterId);
    } catch (error) {
        console.error('Error fetching pages:', error);
    }
}

// Fetch and display the list of books
async function fetchBookList() {
    let endpoint = '/book/admin-portal/books/fetch-books.php';

    try {
        let response = await fetch(endpoint);
        let data = await response.json();
        console.log('Received data:', data);
        clearBookListTable();
        data.forEach(function (book) {
            appendBookListRow(book);
        });
    } catch (error) {
        console.error('Error fetching book list:', error);
    }
}

// Function to append a row to the book list table
function appendBookListRow(book) {
    let bookListTable = document.getElementById('bookListTable');
    let row = document.createElement('tr');

    row.innerHTML = `
        <td><input type='radio' name='bookRadio' data-book-id='${book.book_id}'></td>
        <td>${book.book_id}</td>
        <td>${book.title}</td>
        <td>${book.author}</td>
        <td>${book.year}</td>
        <td>${book.description}</td>
        <td>${book.image_url}</td>
        <td>${book.video_url}</td>
        <td>${book.deleted ? 'Yes' : 'No'}</td>
        <td>${book.live ? 'Yes' : 'No'}</td>
    `;

    bookListTable.querySelector('tbody').appendChild(row);
}

// Function to select a book
function selectBook() {
    let selectedRadio = document.querySelector('input[name="bookRadio"]:checked');

    if (selectedRadio) {
        let bookId = selectedRadio.getAttribute('data-book-id');
        showEditSections(bookId);
    } else {
        alert("Please select a book.");
    }
}

// Function to clear the book list table
function clearBookListTable() {
    let bookListTable = document.getElementById('bookListTable');
    bookListTable.querySelector('tbody').innerHTML = '';
}

// Function to refresh the book list
function refreshBookList() {
    fetchBookList();
}

function getNewBookFormData() {
    return {
        title: document.getElementById('title').value || "",
        author: document.getElementById('author').value || "",
        year: document.getElementById('year').value || "",
        description: document.getElementById('description').value || "",
        image_url: document.getElementById('image_url').value || "",
        video_url: document.getElementById('video_url').value || "",
        choice_text: null
    };
}
// Helper function to handle the response after saving a new book
function handleNewBookSaveResponse(response) {
    if (response && response.message && response.message.includes("successfully")) {
        clearNewBookForm();
        hideNewBookModal();
        refreshBookList();
        alert("Success: " + response.message);
        logBookDetails(response.bookDetails);
    } else {
        alert("Error saving new book: " + (response.error || "Unknown error"));
    }
}

// Helper function to handle errors after saving a new book
function handleNewBookSaveError(error) {
    console.error('Error saving new book:', error);
    alert("Error saving new book. Please try again.");
}

// Create a reference to the modal
var createBookModal;

document.addEventListener('DOMContentLoaded', (event) => {
    createBookModal = new bootstrap.Modal(document.getElementById('createBookModal'));
});

function showCreateBookForm() {
    // Clear the form fields when opening the modal
    document.getElementById('createBookForm').reset();

    // Show the modal
    createBookModal.show();
}

// Function to Save new book
async function saveNewBook() {
    // Get the form data
    var formData = getNewBookFormData();

    // Convert the form data to a URL-encoded string
    var formBody = Object.keys(formData).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(formData[key])).join('&');

    // Make a fetch request to save the new book
    try {
        let response = await fetch('/book/admin-portal/books/add-book.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formBody
        });

        if (response.ok) {
            let data = await response.json();
            handleSaveNewBookResponse(data);
        } else {
            console.error('Error saving new book:', response);
            alert("Error saving new book. Please try again.");
        }
    } catch (error) {
        console.error('Error saving new book:', error);
        alert("Error saving new book. Please try again.");
    }
}

// Create a consistent function for handling the response after saving a new book
function handleSaveNewBookResponse(response) {
    if (response && response.message && response.message.includes("successfully")) {
        // Clear the form values
        clearNewBookForm();

        // Close the modal
        createBookModal.hide();

        // Refresh the book list
        refreshBookList();

        // Display success alert
        alert("Success: " + response.message);

        // Optionally, you can handle the book details here if needed
        var bookDetails = response.bookDetails;
        console.log("Book Details:", bookDetails);
    } else {
        // Display an error message or handle the error accordingly
        alert("Error saving new book: " + (response.error || "Unknown error"));
    }
}
// Function to clear the new book form
function clearNewBookForm() {
    document.getElementById('createBookForm').reset();
}

// Function to show the new book modal
function showNewBookModal() {
    document.getElementById('createBookModal').style.display = 'block';
}

// Function to hide book list section
function hideBookListSection() {
    document.getElementById('bookListSection').style.display = 'none';
}

// Function to show specific sections
function showSections(sectionIds) {
    sectionIds.forEach(function (sectionId) {
        document.getElementById(sectionId).style.display = 'block';
    });
}

// Function to load book details for editing
function loadBookDetails(bookId) {
    fetchSelectedBook(bookId)
        .then((bookDetails) => {
            // Update the selectedBookId after the AJAX call is complete
            selectedBookId = bookId;

            clearBookDetailsTable();
            displayBookDetails(bookDetails);
            showBookDetailsSection();
        })
        .catch((error) => {
            console.error('Error loading book details:', error);
        });
}

// Function to fetch selected book details from the server
async function fetchSelectedBook(bookId) {
    try {
        let response = await fetch('/book/admin-portal/books/fetch-book-data.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ book_id: bookId })
        });

        if (response.ok) {
            return await response.json();
        } else {
            throw new Error('Error fetching book details');
        }
    } catch (error) {
        console.error('Error fetching book details:', error);
    }
}

/*
// Function to fetch selected book preferences from the server
async function fetchSelectedBookPreferences(bookId) {
    try {
        let response = await fetch('/book/admin-portal/books/fetch-selected-book-preferences.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ book_id: bookId })
        });

        if (response.ok) {
            return await response.json();
        } else {
            throw new Error('Error fetching book preferences');
        }
    } catch (error) {
        console.error('Error fetching book preferences:', error);
    }
}

*/

// Function to clear the book details table
function clearBookDetailsTable() {
    document.getElementById('bookDetailsTableBody').innerHTML = '';
}

// Function to clear the book preferences table
function clearBookPreferencesTable() {
    document.getElementById('bookPreferencesTableBody').innerHTML = '';
}

// Function to fetch pages for a given book and chapter
async function fetchPages(bookId, chapterId) {
    try {
        const response = await fetch('/book/admin-portal/books/fetch-selected-book-pages.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                bookId: bookId,
                chapterId: chapterId,
            })
        });

        if (response.ok) {
            const data = await response.json();
            return data.pages; // Assuming your API response has a 'pages' property
        } else {
            throw new Error('Error fetching pages');
        }
    } catch (error) {
        console.error('Error fetching pages:', error);
    }
}

// Function to save changes for a page
async function savePageChanges(pageId, chapterId) {
    // Get the content from the textarea
    var content = document.getElementById('contentInput' + pageId).value;

    // Send a request to save the changes
    try {
        const response = await fetch('/book/admin-portal/books/edit-page.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                page_id: pageId,
                chapter_id: chapterId,
                content: content
            })
        });

        if (response.ok) {
            const data = await response.json();
            console.log('Changes saved successfully:', data.message);
        } else {
            throw new Error('Error saving changes');
        }
    } catch (error) {
        console.error('Error saving changes:', error);
    }
}

// Function to load pages for all chapters
async function loadPagesForAllChapters(selectedBookId, chapters) {
    // Assuming you have a variable to store the selected page ID
    selectedPageId;

    // Iterate through chapters and fetch pages for each chapter
    for (let i = 0; i < chapters.length; i++) {
        const chapter = chapters[i];
        try {
            const pages = await fetchSelectedBookPages(selectedBookId, chapter.chapter_id, selectedPageId);
            console.log('Fetched pages for chapter ' + chapter.chapter_id + ':', pages);

            // Use a template to generate HTML for each page
            var pageItemTemplate = '<li>' +
                'Page ID: {{page_id}}, ' +
                'Page Number: {{page_number}}, ' +
                'Content: {{content}}, ' +
                'Choices: {{choices}}' +
                '</li>';

            // Display pages for the current chapter
            displayPages(pages, chapter.chapter_id, pageItemTemplate, selectedPageId);
        } catch (error) {
            console.error('Error fetching pages:', error);
        }
    }
}

// Function to show the book details section
function showBookDetailsSection() {
    document.getElementById('bookListSection').style.display = 'none';
    document.getElementById('bookDetailsSection').style.display = 'block';
}

// Function to save edited book details
function saveEditedBookDetails() {
    // Fetch the book ID from the hidden input field
    var bookId = document.getElementById('bookDetailsBookId').value;

    // Prepare data for the AJAX request
    var formData = new FormData(document.getElementById('editBookDetailsForm'));

    // Send AJAX request to save edited book details
    fetch('/book/admin-portal/books/save-edited-book-details.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => handleSaveResponse(data))
    .catch(error => {
        console.error('Error saving book details:', error);
        alert('An error occurred while saving book details. Please try again.');
    });
}

// Function to handle the response after saving book details
function handleSaveResponse(response) {
    if (response && response.message) {
        // Display a success message
        alert(response.message);
        // Optionally, you can refresh the book list or perform other actions
    } else if (response && response.error) {
        // Display an error message
        alert('Error: ' + response.error);
    } else {
        // Display a generic error message
        alert('An unknown error occurred while saving book details.');
    }
}

/*
// Function to save edited book preferences
function saveEditedBookPreferences() {
    var formData = new FormData(document.getElementById('editBookPreferencesForm'));

    fetch('/book/admin-portal/books/save-edited-book-preferences.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.message) {
            alert(data.message);
        } else if (data && data.error) {
            alert('Error: ' + data.error);
        } else {
            alert('An unknown error occurred while saving book preferences.');
        }
    })
    .catch(error => {
        console.error('Error saving book preferences:', error);
        alert('An error occurred while saving book preferences. Please try again.');
    });

    // Prevent the default form submission
    return false;
}
*/
// Function to save edited book chapters
function saveEditedBookChapters() {
    var formData = new FormData(document.getElementById('editBookChaptersForm'));

    fetch('/book/admin-portal/books/save-edited-book-chapters.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => handleSaveEditedDataResponse(data))
    .catch(error => handleSaveEditedDataError(error));

    // Prevent the default form submission
    return false;
}

// Function to save the new chapter
function saveNewChapter() {
    var newChapterNumber = document.getElementById('newChapterNumber').value;
    var newStoryline = document.getElementById('newStoryline').value;
    var newAffinityRequirement = document.getElementById('newAffinityRequirement').value;

    var data = {
        book_id: document.getElementById('bookChaptersBookId').value,
        chapter_number: newChapterNumber,
        storyline: newStoryline,
        affinity_requirement: newAffinityRequirement
    };

    fetch('/book/admin-portal/books/save-new-chapter.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.message) {
            console.log(data.message);
            refreshBookChaptersList();
            document.getElementById('addChapterModal').style.display = 'none';
        } else if (data && data.error) {
            console.error('Error: ' + data.error);
        } else {
            console.error('An unknown error occurred while saving the new chapter.');
        }
    })
    .catch((error) => {
        console.error('Error saving new chapter:', error);
    });
}

// Function to open the "Add New Chapter" modal
function openAddChapterModal() {
    var nextChapterNumber = getNextChapterNumber();
    document.getElementById('newChapterNumber').value = nextChapterNumber;
    document.getElementById('addChapterModal').style.display = 'block';
}

// Function to get the next chapter number
function getNextChapterNumber() {
    var highestChapterNumber = 0;
    var chapterNumbers = document.querySelectorAll('input[name="chapter_number[]"]');

    chapterNumbers.forEach(function(chapterNumberInput) {
        var chapterNumber = parseInt(chapterNumberInput.value, 10);
        if (!isNaN(chapterNumber) && chapterNumber > highestChapterNumber) {
            highestChapterNumber = chapterNumber;
        }
    });

    return highestChapterNumber + 1;
}

// Function to refresh the book chapters list
function refreshBookChaptersList() {
    document.getElementById('bookChaptersTableBody').innerHTML = '';

    var bookId = document.getElementById('bookChaptersBookId').value;
    fetchSelectedBookChapters(bookId)
        .then(function (bookChapters) {
            displayBookChapters(bookChapters);
        })
        .catch(function (error) {
            console.error('Error fetching book chapters:', error);
        });
}

// Function to save common data for edited book details, preferences, chapters, and pages
function saveEditedData(url, bookId, formData) {
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => handleSaveEditedDataResponse(data))
    .catch(error => handleSaveEditedDataError(error));
}

// Helper function to handle response after saving edited data
function handleSaveEditedDataResponse(response) {
    if (response && response.message) {
        alert(response.message);
    } else if (response && response.error) {
        alert('Error: ' + response.error);
    } else {
        alert('An unknown error occurred while saving data.');
    }
}

// Helper function to handle errors after saving edited data
function handleSaveEditedDataError(error) {
    console.error('Error saving data:', error);
    alert('An error occurred while saving data. Please try again.');
}

// Function to hide specific sections
function hideSections(sectionIds) {
    sectionIds.forEach(function (sectionId) {
        var element = document.getElementById(sectionId);
        if (element) {
            element.style.display = 'none';
        } else {
            console.warn('Element with ID ' + sectionId + ' not found');
        }
    });
}

// Function to show specific sections
function showSections(sectionIds) {
    sectionIds.forEach(function (sectionId) {
        var element = document.getElementById(sectionId);
        if (element) {
            element.style.display = 'block';
        } else {
            console.warn('Element with ID ' + sectionId + ' not found');
        }
    });
}

// Function to log book details to the console
function logBookDetails(bookDetails) {
    console.log("Book Details:", bookDetails);
}

// Function to load choices for a page
function loadChoicesForPage(bookId, chapterId, pageId, callback) {
    // Log the bookData
    console.log('Current book data:', bookData);

    // Find the page in bookData
    const page = bookData.pages.find(p => p.page_id === pageId);

    if (!page) {
        console.error('Page not found:', pageId);
        return;
    }

    // Find the choices for the page in bookData
    const choices = bookData.choices.filter(c => c.page_id === pageId);

    console.log('Choices loaded successfully for page ' + pageId, choices);

    if (typeof callback === 'function') {
        // Pass the correct parameters to the callback function, including choice_id
        callback(choices, pageId, chapterId, bookId, choices.map(c => c.choice_id), choices.length);
    } else {
        console.error('Callback is not a function:', callback);
    }
}

// Function to get the selected choice based on the radio button
function getSelectedChoice(pageId) {
    var selectedChoice = document.querySelector('input[name="choiceRadio' + pageId + '"]:checked').value;
    return selectedChoice ? parseInt(selectedChoice) : 1; // Default to 1 if no choice is selected
}

// Function to create a new page and save the choice
function createNewPageAndSaveChoice(pageId, chapterId, choiceText) {
    // Create Page
    fetch('/book/admin-portal/books/add-pages.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            book_id: selectedBookId,
            chapter_id: chapterId,
            page_number: pageId + 1, // Assuming sequential page numbers
            content: choiceText || "",
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('New page created successfully:', data);

        // Display success alert for creating a new page
        alert('New page created successfully!');

        // Obtain Page's ID
        var newPageId = data.page_id;

        // Create a new choice (Choice 1) for the current page using the new page's ID as the target
        saveChoice(newPageId, chapterId, choiceText, pageId);
    })
    .catch(error => {
        console.error('Error creating new page:', error);
        // Display error alert for creating a new page
        alert('Error creating new page. Please try again.');
    });
}
// Function to save a choice
function saveChoice(pageId, chapterId, choiceText, targetPage) {
    // Save Choice
    fetch('/book/admin-portal/books/add-choices.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            page_id: pageId,
            choice_text: choiceText,
            target_page: targetPage
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('New choice saved successfully:', data);
        alert('New choice saved successfully!');
    })
    .catch((error) => {
        console.error('Error saving new choice:', error);
        alert('Error saving new choice. Please try again.');
    });
}


// Function to get the choice text based on the choice ID
function getChoiceText(choiceId) {
    // Implement logic to retrieve the choice text from the choices object or server based on choice ID
    // Replace the following line with your actual logic
    return 'Choice Text for ID ' + choiceId;
}

// Function to save new page choices
function saveNewPageChoices(chapterId, pageId, choiceText) {
    // Perform a fetch request to add choices for the new page
    fetch('/book/admin-portal/books/add-choices.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            book_id: selectedBookId,
            chapter_id: chapterId,
            page_id: pageId,
            choice_text: choiceText || "", // Use provided choice text or empty string
            target_page: 0
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.message) {
            console.log('Choices added successfully:', data.message);
            // Reload choices for the new page
            loadChoicesForPage(selectedBookId, chapterId, pageId, displayChoices);
        } else if (data && data.error) {
            console.error('Error adding choices:', data.error);
        } else {
            console.error('An unknown error occurred while adding choices.');
        }
    })
    .catch((error) => {
        console.error('Error adding choices:', error);
    });
}

// Function to add a choice
function addChoice(pageId, choiceText) {
    // Create Page 2
    fetch('/book/admin-portal/books/add-pages.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            book_id: selectedBookId,
            chapter_id: chapterId,
            page_number: pageId + 1, // Assuming sequential page numbers
            content: choiceText || "",
            choice_id: 0 // Assuming initial choice_id for the new page
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('New page created successfully:', data);

        // Display success alert for creating a new page
        alert('New page created successfully!');

        // Obtain Page 2's ID
        var newPageId = data.page_id;

        // Create a new choice (Choice 1) for Page 1 using Page 2's ID as the target
        saveChoice(pageId, chapterId, choiceText, newPageId);
    })
    .catch((error) => {
        console.error('Error creating new page:', error);
        // Display error alert for creating a new page
        alert('Error creating new page. Please try again.');
    });
}


// Function to add another choice
function addAnotherChoice(pageId, chapterId, amountOfChoices) {
    var choicesList = document.getElementById('choicesList' + pageId);
    var newChoiceItem = '<li class="list-group-item">' +
        '<input type="text" class="form-control" placeholder="Enter choice text" id="newChoiceInput' + pageId + '">' +
        '<button class="btn btn-success save-choice-btn" onclick="saveChoice(' + pageId + ',' + chapterId + ', document.getElementById(\'newChoiceInput' + pageId + '\').value)">Save</button>' +
        '<button class="btn btn-primary add-another-choice-btn" onclick="addAnotherChoice(' + pageId + ', ' + chapterId + ', ' + amountOfChoices + ')">Add Another Choice</button>' +
        '</li>';
    choicesList.innerHTML += newChoiceItem;
}

// Function to save a new page after creating a new choice
function saveNewPage(bookId, chapterId, pageId, choiceId, choiceText) {
    console.log('Received in saveNewPage:', { bookId, chapterId, pageId, choiceId, choiceText }); // Log the received values

    // Check if choiceId is defined
    if (typeof choiceId !== 'undefined') {
        // Send a fetch request to save the new page
        fetch('/book/admin-portal/books/add-pages.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                book_id: bookId,
                chapter_id: chapterId,
                page_number: pageId,
                content: choiceText || "",
                choice_id: choiceId
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response from server:', data); // Log the response from the server

            // Check for errors
            if (data.error) {
                console.error('Error saving new page:', data.error);
                // Log additional details about the request
                console.log('Request details:', {
                    book_id: bookId,
                    chapter_id: chapterId,
                    page_number: pageId,
                    content: choiceText || "",
                    choice_id: choiceId
                });

                // Display error alert
                alert('Error saving new page: ' + data.error);
            } else {
                console.log('New page saved successfully:', data.message);

                // Optionally, you can perform additional actions after saving the new page

                // Display success alert
                alert('New page saved successfully!');
            }
        })
        .catch((error) => {
            console.error('Error saving new page:', error);
            // Log additional details about the request
            console.log('Request details:', {
                book_id: bookId,
                chapter_id: chapterId,
                page_number: pageId,
                content: choiceText || "",
                choice_id: choiceId
            });

            // Display error alert
            alert('Error saving new page. Please try again.');
        });
    } else {
        console.error('Choice ID is undefined. Cannot save new page.');
    }
}

// Function to refresh the choices list
function refreshChoicesList(pageId, chapterId, amountOfChoices) {
    // Reload choices for the current page after saving
    loadChoicesForPage(selectedBookId, selectedChapterId, pageId, function(choices, pageId, chapterId, amountOfChoices) {
        displayChoices(choices, pageId, chapterId, amountOfChoices);
        // Create a new page using the new choice's ID
        saveNewPage(selectedChapterId, response.choice_id);
    });
}

// Function to edit a choice
function editChoice(choiceId) {
    // Perform edit action with the choice ID
    console.log('Editing choice with ID:', choiceId);
    // Add your edit logic here
}

// Function to fetch pages for a given book and chapter
async function fetchPages(bookId, chapterId) {
    try {
        const response = await fetch(`/book/admin-portal/books/fetch-selected-book-pages.php?bookId=${bookId}&chapterId=${chapterId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            const data = await response.json();
            return data.pages; // Assuming your API response has a 'pages' property
        } else {
            throw new Error('Error fetching pages');
        }
    } catch (error) {
        console.error('Error fetching pages:', error);
    }
}

// Function to save changes for a page
async function savePageChanges(pageId, chapterId) {
    // Get the content from the textarea
    var content = document.getElementById('contentInput' + pageId).value;

    // Send a request to save the changes
    try {
        const response = await fetch('/book/admin-portal/books/edit-page.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                page_id: pageId,
                chapter_id: chapterId,
                content: content
            })
        });

        if (response.ok) {
            const data = await response.json();
            console.log('Changes saved successfully:', data.message);
        } else {
            throw new Error('Error saving changes');
        }
    } catch (error) {
        console.error('Error saving changes:', error);
    }
}

// Function to load pages for all chapters
function loadPagesForAllChapters(selectedBookId, chapters) {
    // Assuming you have a variable to store the selected page ID
    selectedPageId;

    // Iterate through chapters
    for (let i = 0; i < chapters.length; i++) {
        const chapter = chapters[i];

        // Find the pages for the chapter in bookData
        const pages = bookData.pages.filter(p => p.chapter_id === chapter.chapter_id);

        console.log('Loaded pages for chapter ' + chapter.chapter_id + ':', pages);

        // Use a template to generate HTML for each page
        var pageItemTemplate = '<li>' +
            'Page ID: {{page_id}}, ' +
            'Page Number: {{page_number}}, ' +
            'Content: {{content}}, ' +
            'Choices: {{choices}}' +
            '</li>';

        // Display pages for the current chapter
        displayPages(pages, chapter.chapter_id, pageItemTemplate, selectedPageId);
    }
}

// Update the event handlers for "Edit" and "Delete" buttons
document.addEventListener('click', function (event) {
    if (event.target.matches('.edit-choice-btn')) {
        // Find the selected radio button
        var selectedChoiceId = document.querySelector('input[name="choiceRadio"]:checked').value;

        if (selectedChoiceId) {
            // Call the editChoice function with the selected choice ID
            editChoice(selectedChoiceId);
        } else {
            console.log('No choice selected for editing.');
        }
    }
});

// Function to get the selected chapterId 
function getSelectedChapterId() {
    var selectedChapterRadio = document.querySelector('input[name="selectedChapter"]:checked');
    return selectedChapterRadio ? selectedChapterRadio.value : null;
}

// Function to handle chapter selection
function selectChapter() {
    var selectedChapterId = getSelectedChapterId();
    if (selectedChapterId) {
        // Load pages and choices for the selected chapter
        loadPagesAndChoices(selectedBookId, selectedChapterId);
    } else {
        console.error('Error: No chapter selected.');
    }
}

// Function to clear previous content
function clearPreviousContent() {
    // Assuming 'pagesContainer' and 'choicesContainer' are the containers for pages and choices
    document.getElementById('pagesContainer').innerHTML = '';
    document.getElementById('choicesContainer').innerHTML = '';
}

// Function to display book pages
function displayBookPages(bookPages, chapterId) {
    var pagesList = document.getElementById('pagesList');
    pagesList.innerHTML = '';

    if (bookPages.length > 0) {
        bookPages.forEach(function (page) {
            var pageItem = document.createElement('li');
            pageItem.innerHTML = 
                '<input type="radio" name="selectedPage" value="' + page.page_id + '" data-chapter-id="' + page.chapter_id + '">' +
                'Page ID: ' + page.page_id +
                ', Chapter ID: ' + page.chapter_id +
                ', Page Number: ' + page.page_number +
                ', Content: ' + page.content +
                ', Choices: ' + page.choices +
                ' <button class="btn btn-success" onclick="openEditPageModal(' + page.page_id + ', ' + chapterId + ')">Edit Page</button>';

            pagesList.appendChild(pageItem);
        });
    } else {
        pagesList.innerHTML = '<li>No pages available for this chapter.</li>';
    }
}

// Function to initialize the chapter select options
function initializeChapterSelect() {
    var chapterSelect = document.getElementById('chapterSelect');
    chaptersData.forEach(function (chapter) {
        var option = document.createElement('option');
        option.value = chapter.id;
        option.text = chapter.name;
        chapterSelect.appendChild(option);
    });
}

// Function to open the New Chapter modal
function openNewChapterModal() {
    // Clear any existing data in the modal form
    // ...

    // Show the modal
    var newChapterModal = new bootstrap.Modal(document.getElementById('newChapterModal'));
    newChapterModal.show();
}

// Function to delete a page and its choices
function deletePage(pageId, chapterId) {
    // Confirm the deletion with the user
    if (confirm('Are you sure you want to delete this page?')) {
        // Send an AJAX request to delete the page and its choices
        fetch('/book/admin-portal/books/delete-page.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ page_id: pageId })
        })
        .then(response => response.json())
        .then(data => {
            // Handle success (reload pages and choices)
            if (!data.error) {
                // Reload pages and choices for the current chapter
                fetchSelectedBookPages(selectedBookId, chapterId)
                .then(function (pages) {
                    displayPagesInAccordion(chapterId, pages);
                })
                console.log('Page deleted successfully:', data.message);
            } else {
                console.error('Error deleting page:', data.error);
            }
        })
        .catch((error) => {
            console.error('AJAX error:', error);
        });
    }
}

// Update the event handlers for "delete page" and "Delete" buttons
document.addEventListener('click', function (event) {
    if (event.target.matches('.delete-page-btn')) {
        // Extract page and chapter IDs from data attributes
        var pageId = event.target.dataset.pageId;
        var chapterId = event.target.dataset.chapterId;

        // Log IDs for debugging
        console.log('Delete page pageId:', pageId);
        console.log('Delete page chapterId:', chapterId);

        // Call the deletePage function
        deletePage(pageId, chapterId);
    }
});


// Add event listener to the document
document.addEventListener('click', function(event) {
    // Check if the clicked element is the one you care about
    if (event.target.matches('#savePageButton')) {
        // Save the page
        saveNewPage();
    }
});

// Add a click event listener to the document
document.addEventListener('click', function (event) {
    // Check if a chapter list item was clicked
    if (event.target.matches('#chaptersList li')) {
        // Fetch the selected book ID and chapter ID
        var selectedBookId = document.getElementById('bookList').value;
        var selectedChapterId = event.target.dataset.chapterId;

        // Check if a book is selected
        if (selectedBookId) {
            // Load book details for editing
            loadBookDetailsForEditing(selectedBookId);

            // Fetch chapter details
            fetch('/book/admin-portal/books/fetch-selected-chapter.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ book_id: selectedBookId, chapter_id: selectedChapterId })
            })
            .then(response => response.json())
            .then(chapterDetails => {
                // Set selectedChapterId using the fetched data
                selectedChapterId = chapterDetails.chapter_id;

                // Load pages for the selected chapter
                loadPagesAndChoices(selectedBookId, selectedChapterId);
            })
            .catch(error => {
                console.error('Error fetching chapter details:', error);
            });
        } else {
            // Inform the user to select a book
            alert('Please select a book before editing.');
        }
    }
});



// Event delegation for dynamically loaded elements
document.addEventListener('click', function (event) {
    // Check if the "Add Chapter" button was clicked
    if (event.target.matches('#addNewChapterBtn')) {
        openAddChapterModal();
    }
    // Check if the "Save Changes" button in the modal was clicked
    else if (event.target.matches('#saveNewChapterBtn')) {
        saveNewChapter();
    }
    // Check if the "Close Book Details" button was clicked
    else if (event.target.matches('#closeBookDetailsBtn')) {
        showBookList();
    }
    // Check if the "Book Management" button was clicked
    if (event.target.matches('#bookManagementBtn')) {
        fetchBookList();
        hideSections(['home', 'userManagement', 'newsManagement']);
        showSections(['bookManagement']);
    }
    // Check if the "Home" button was clicked
    else if (event.target.matches('#homeBtn')) {
        loadContent('home');
    }
    // Check if the "User Management" button was clicked
    else if (event.target.matches('#userManagementBtn')) {
        loadContent('user-management');
    }
    // Check if the "News Management" button was clicked
    else if (event.target.matches('#newsManagementBtn')) {
        loadContent('news-management');
    }
});

// Function to set the selectedBookId in a global variable
function setGlobalSelectedBookId(bookId) {
    selectedBookId = bookId;
}

function openNewPageModal(chapterId, choiceId) {
    // Calculate the new page number (increment by 1)
    var existingPagesCount = document.querySelectorAll('#pagesAndChoicesList' + chapterId + ' li').length;
    var newPageNumber = existingPagesCount + 1;

    // Set the auto-incremented page number in the modal
    document.getElementById('newPageNumber').value = newPageNumber;

    // Set selectedChapterId
    selectedChapterId = chapterId;

    // Show the modal
    var addPageModal = new bootstrap.Modal(document.getElementById('addPageModal'));
    addPageModal.show();

    // Save the new page when the modal is shown
    saveNewPage(chapterId);
}


function loadContent(page) {
    var dynamicContent = document.getElementById('dynamicContent');

    switch(page) {
        case 'home':
            dynamicContent.innerHTML = document.getElementById('home').innerHTML;
            break;
        case 'user-management':
            // Load user management content
            break;
        case 'news-management':
            // Load news management content
            break;
        case 'book-management':
            // Load book management content
            break;
        default:
            dynamicContent.innerHTML = '<p>Page not found.</p>';
    }
}


</script>
</head>
<body>

<!------------------------- Bootstrap Navbar ------------------------------------------------------------->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" id="homeBtn">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="userManagementBtn">User Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="newsManagementBtn">News Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="bookManagementBtn">Book Management</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- admin-portal.php  Entire Page Container -------------------------------------------------------------------------------->
<div class="container mt-5">
<!--------------------------- Page content ---------------------------------------------------------------->
<div class="content">
    <div id="dynamicContent">
        <!-- Content will be loaded here -->
    </div>
</div>
<!--------------------------- Home Section ---------------------------------------------------------------->
<div id="home">
    <div class="container mt-5">
        <h2>Welcome to the Admin Portal</h2>
        <p>This is the landing page for the Admin Portal. Use the navigation links to manage users and news articles.</p>
    </div>
</div>

<!--------------------------- Book Management Section ----------------------------------------------------->
<div id="bookManagement" style="display: none;">
    <h1>Book Management 1.1</h1>

    <div id="bookListSection">
        <h2>Book List</h2>
        <table id="bookListTable" class="table table-striped table-bordered">
            <!-- Table headers -->
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Description</th>
                    <th>Image URL</th>
                    <th>Video URL</th>
                    <th>Deleted</th>
                    <th>Live</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Book list items will be dynamically added here -->
            </tbody>
        </table>
        <!-- Select Book Button -->
        <div id="selectBookSection">
        <div>
        <button id="createBookBtn" class="btn btn-primary" onclick="showCreateBookForm()">Create Book</button>
        <button id="selectBookBtn" class="btn btn-primary" onclick="selectBook()">Select Book</button>
        </div>
        </div>
    </div>


    <!-- Create Book Section -->
<div id="createBookSection">

    <!-- Create Book Modal -->
    <div class="modal fade" id="createBookModal" tabindex="-1" role="dialog" aria-labelledby="createBookModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBookModalLabel">Create New Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Create Book Form -->

                    <form id="createBookForm">
                        <div class="mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author">
                        </div>
                        <div class="mb-3">
                            <label for="year">Year</label>
                            <input type="number" class="form-control" id="year" name="year">
                        </div>
                        <div class="mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_url">Image URL</label>
                            <input type="text" class="form-control" id="image_url" name="image_url">
                        </div>
                        <div class="mb-3">
                            <label for="video_url">Video URL</label>
                            <input type="text" class="form-control" id="video_url" name="video_url">
                        </div>
                        <!-- Hidden Fields for deleted and live -->
                        <input type="hidden" name="deleted" value="0">
                        <input type="hidden" name="live" value="0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="saveNewBook()">Save Book</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
   <!-- Selected Book Editing Section-->
    <div id="bookDetailsSection" style="display: none;">
        <div>
    <button id="closeBookDetailsBtn" class="btn btn-primary">Close Book</button>
    <button id="deleteBookBtn" class="btn btn-danger">Delete Book</button>
    </div>
		<div id="accordion">


        <!-- Book Details --->
  <div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
        DETAILS
      </a>
    </div>
    <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
        <form id="editBookDetailsForm">
                        <!-- Table to display book details -->
                        <div class="table-responsive">
                            <table class="table" id="bookDetailsTable">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody id="bookDetailsTableBody">
                                    <!-- Book details will be dynamically added here -->
                                </tbody>
                            </table>
                            <input type="hidden" id="bookDetailsBookId" name="book_id" value="...">
							<button type="button" id="saveEditedBookDetailsBtn" class="btn btn-primary" onclick="saveEditedBookDetails()">Save Changes</button>
                        </div>
                    </form>

      </div>
    </div>
  </div>


<!-- Book Preferences --->
<div class="card" id="preferencesAccordion">
    <div class="card-header">
        <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
            PREFERENCES
        </a>
    </div>
    <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
        <div class="card-body">
            <form id="editBookPreferencesForm">
                <!-- Table to display book preferences -->
                <div class="table-responsive">
                    <table class="table" id="bookPreferencesTable">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody id="bookPreferencesTableBody">
                            <!-- Book preferences will be dynamically added here -->
                        </tbody>
                    </table>

                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Chapters Section -->
<div id="bookChaptersDrop">
<div class="card">
    <div class="card-header">
	<input type="hidden" id="bookChaptersBookId" name="book_id" value="...">

        <a class="collapsed btn" id="" data-bs-toggle="collapse" href="#collapseChapters">
            CHAPTERS
        </a>
    </div>
    <div id="collapseChapters" class="collapse" data-bs-parent="#accordion">
        <div class="card-body">

            <!-- Container for chapters -->
            <div id="chaptersContainer">
                <!-- Repeat the below structure for each chapter -->
                <!-- Card for each chapter -->
                
            </div>
        </div>
    </div>
</div>
</div>
<!-- Edit Chapter Modal -->
<div class="modal" id="editChapterModal" tabindex="-1" role="dialog">
  <!-- Modal content -->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Chapter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for editing chapter details -->
        <!-- Include input fields for chapter details -->
        <!-- Adjust as needed based on your requirements -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- New Chapter Modal -->
<div class="modal" id="newChapterModal" tabindex="-1" role="dialog">
  <!-- Modal content -->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Chapter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for creating a new chapter -->
        <!-- Include input fields for new chapter details -->
        <!-- Adjust as needed based on your requirements -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Create Chapter</button>
      </div>
    </div>
  </div>
</div>


        </div>
    </div>
</div>

</div>

	<!-- Modal for adding a new chapter -->
<div class="modal fade" id="addChapterModal" tabindex="-1" aria-labelledby="addChapterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addChapterModalLabel">Add New Chapter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Input fields for the new chapter -->
                <div class="mb-3">
                    <label for="newChapterNumber" class="form-label">Chapter Number</label>
                    <input type="text" class="form-control" id="newChapterNumber" readonly>
                </div>
                <div class="mb-3">
                    <label for="newStoryline" class="form-label">Storyline</label>
                    <input type="text" class="form-control" id="newStoryline">
                </div>
                <div class="mb-3">
                    <label for="newAffinityRequirement" class="form-label">Affinity Requirement</label>
                    <input type="text" class="form-control" id="newAffinityRequirement">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveNewChapterBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add New Page Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1" role="dialog" aria-labelledby="addPageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPageModalLabel">Add New Page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Input fields for the new page -->
                <div class="mb-3">
                    <label for="newPageContent">Page Content:</label>
                    <textarea class="form-control" id="newPageContent" name="newPageContent" placeholder="Add your creative storyline for this page here..." required></textarea>
                </div>
                <!-- Hidden input to store the chapterId -->
                <input type="hidden" id="newPageChapterId">
                <!-- Hidden input to store the auto-incremented page number -->
                <input type="text" class="form-control" id="newPageNumber" readonly>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savePageButton">Save Page</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Choice Modal -->
<div class="modal" tabindex="-1" id="editChoiceModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Choice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="editedChoiceText" class="form-label">Choice Text</label>
                        <input type="text" class="form-control" id="editedChoiceText">
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="editChoiceModalFooter">
                <button type="button" class="btn btn-secondary" id="cancelEditedChoice" data-bs-dismiss="modal">Cancel</button>
                <!-- <button type="button" class="btn btn-danger" id="deleteChoice">Delete</button> -->
                <button type="button" class="btn btn-primary" id="saveEditedChoice">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!--Edit preferences modal -->

<div class="modal" tabindex="-1" id="editPreferencesModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Book Preferences</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPreferencesForm">
                    <div class="mb-3">
                        <label for="targetAgeInput" class="form-label">Target Age</label>
                        <input type="text" class="form-control" id="targetAgeInput">
                    </div>
                    <div class="mb-3">
                        <label for="bookSizeInput" class="form-label">Book Size</label>
                        <input type="text" class="form-control" id="bookSizeInput">
                    </div>
                    <div class="mb-3">
                        <label for="containsMiniGamesInput" class="form-label">Contains Mini Games</label>
                        <input type="text" class="form-control" id="containsMiniGamesInput">
                    </div>
                    <div class="mb-3">
                        <label for="difficultyInput" class="form-label">Difficulty</label>
                        <input type="text" class="form-control" id="difficultyInput">
                    </div>
                    <div class="mb-3">
                        <label for="genreInput" class="form-label">Genre</label>
                        <input type="text" class="form-control" id="genreInput">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesButton">Save changes</button>
            </div>
        </div>
    </div>
</div>



<!-- Add Choice Modal -->
<div class="modal fade" id="addChoiceModal" tabindex="-1" role="dialog" aria-labelledby="addChoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addChoiceModalLabel">Add New Choice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addChoiceForm">
                    <div class="form-group">
                        <label for="choiceText">Choice Text</label>
                        <input type="text" class="form-control" id="choiceText" placeholder="Enter choice text">
                    </div>
                    <div class="form-group">
                        <label for="choiceNumber">Choice Number</label>
                        <input type="number" class="form-control" id="choiceNumber" placeholder="Enter choice number">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChoiceButton">Save Choice</button>
            </div>
        </div>
    </div>
</div>

</div>

<!--------------------------- User Management Section ----------------------------------------------------->
<div id="userManagement" style="display: none;">
    <div class="container mt-5">

        <h2>User Management</h2>
        <!-- Add User Section -->
        <div class="mb-5">
            <h2>Add User</h2>
            <form id="addUserForm" action="/book/admin-portal/users/add-user.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="Date of Birth" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="country" name="country" placeholder="Country" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="gender" name="gender" placeholder="Gender">
                </div>
                <button type="submit" class="btn btn-primary">Add User</button>
            </form>
        </div>

        <!-- Edit and Remove User Section -->
        <div class="mb-5">
            <h2>Edit and Remove User</h2>
            <!-- List of Users -->
            <ul id="userList" class="list-group">
                <!-- User details will be displayed here dynamically -->
            </ul>
            <!-- Edit and Remove Buttons -->
            <button type="button" class="btn btn-warning mt-3" onclick="editSelectedUser()">Edit Selected User</button>
            <button type="button" class="btn btn-danger mt-3" onclick="removeSelectedUser()">Remove Selected User</button>
        </div>

        <!-- Edit User Form -->
        <div id="editUserFormSection" style="display: none;">
            <h2>Edit User</h2>
            <form id="editUserForm" action="save-changes.php" method="post">
                <!-- Fields for editing user data -->
                <div class="mb-3">
                    <input type="text" class="form-control" id="editUserId" name="user_id" readonly>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newUsername" name="new_username" placeholder="New Username">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="newEmail" name="new_email" placeholder="New Email">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="New Password">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newFullName" name="new_full_name" placeholder="New Full Name">
                </div>
                <div class="mb-3">
                    <input type="date" class="form-control" id="newDateOfBirth" name="new_date_of_birth" placeholder="New Date of Birth">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newCountry" name="new_country" placeholder="New Country">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newGender" name="new_gender" placeholder="New Gender">
                </div>
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
            </form>
        </div>

    </div>
</div>
<!--------------------------- News Management Section ----------------------------------------------------->
<div id="newsManagement" style="display: none;">
    <div class="container mt-5">

        <h2>News Management</h2>
        <!-- Add News Section -->
        <div class="mb-5">
            <h2>Add News Article</h2>
            <form id="addNewsForm" action="add-news.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" id="headline" name="headline" placeholder="Headline" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="article" name="article" placeholder="Article Content" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Add News</button>
            </form>
        </div>

        <!-- Edit and Remove News Section -->
        <div class="mb-5">
            <h2>Edit and Remove News</h2>
            <!-- List of News Articles -->
            <ul id="newsList" class="list-group">
                <!-- News details will be displayed here dynamically -->
            </ul>
            <!-- Edit and Remove Buttons -->
            <button type="button" class="btn btn-warning mt-3" onclick="editSelectedNews()">Edit Selected News</button>
            <button type="button" class="btn btn-danger mt-3" onclick="removeSelectedNews()">Remove Selected News</button>
        </div>

        <!-- Edit News Form -->
        <div id="editNewsFormSection" style="display: none;">
            <h2>Edit News Article</h2>
            <form id="editNewsForm" action="save-news-changes.php" method="post">
                <!-- Fields for editing news data -->
                <div class="mb-3">
                    <input type="text" class="form-control" id="editNewsId" name="news_id" readonly>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="newHeadline" name="new_headline" placeholder="New Headline">
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="newArticle" name="new_article" placeholder="New Article Content" rows="5"></textarea>
                </div>
                <!-- Optional Image Upload -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image (Optional)</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveNewsChanges()">Save Changes</button>
            </form>
        </div>

    </div>
</div>


<script>
// Define the loadContent function

$(document).ready(function () {
///////////////////////////////////USER MANAGEMENT////////////////////////////////////////////
// Fetch and display the list of users
function fetchUserList() {
        $.ajax({
            url: '/book/admin-portal/users/fetch-users.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Clear existing list
                $('#userList').empty();

                // Display users in the list
                data.forEach(function (user) {
                    $('#userList').append('<li class="list-group-item">' +
                        '<input type="checkbox" class="form-check-input" name="selectedUsers[]" value="' + user.user_id + '">' +
                        ' ' + user.username +
                        '</li>');
                });
            },
           error: function (xhr, status, error) {
    console.error('Error fetching user list. Status:', status, 'Error:', error);
}

        });
    }
// Add User Section
$('#addUserForm').submit(function (event) {
        // Prevent the form from submitting in the traditional way
        event.preventDefault();

        // Collect form data
        var formData = $(this).serialize();

        // Send an AJAX request to add user
        $.ajax({
            url: '/book/admin-portal/users/add-user.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Display success or error alert
                if (response.message) {
                    alert(response.message);
                } else if (response.error) {
                    alert('Error: ' + response.error);
                }

                // Refresh the user list after adding a user
                fetchUserList();
            },
            error: function (error) {
                console.error('Error adding user:', error);
            }
        });
    });
// Edit selected user
function editSelectedUser() {
    var selectedUsers = $("input[name='selectedUsers[]']:checked");

    if (selectedUsers.length === 1) {
        var userId = selectedUsers.val();

        // Fetch user details for editing
        $.ajax({
            url: '/book/admin-portal/users/fetch-user-details.php',
            method: 'GET',
            data: {user_id: userId},
            dataType: 'json',
            success: function (userData) {
                // Display the user details in the edit form
                $('#editUserId').val(userData.user_id);
                // Set values for other fields
                $.each(userData, function (key, value) {
                    if (key === 'age') {
                        // Set the value of newDateOfBirth field
                        $('#newDateOfBirth').val(value);
                    } else if (key === 'password_hash') {
                        // You may choose not to populate the password field for security reasons
                       // $('#newPassword').val(value);
					} else if (key === 'gender') {
                        // Set gender val
                        $('#newGender').val(value);
                    } else if (key === 'name') {
                        // Set the value of newFullName field
                        $('#newFullName').val(value);
                    } else {
                        // Set values for other fields
                        $('#new' + key.charAt(0).toUpperCase() + key.slice(1)).val(value);
                    }
                });

                // Hide user list and display the edit form
                $('#userList').hide();
                $('#editUserFormSection').show();
            },
            error: function (xhr, status, error) {
    console.error('Error fetching user details. Status:', status, 'Error:', error);
}

        });
    } else {
        alert('Please select exactly one user to edit.');
    }
}
// Function to format date in yyyy-mm-dd to a user-friendly format
function formatDate(dateString) {
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}
// Remove selected user
function removeSelectedUser() {
    var selectedUsers = $("input[name='selectedUsers[]']:checked");

    if (selectedUsers.length > 0) {
        if (confirm('Are you sure you want to remove the selected user(s)?')) {
            // Proceed with removing the selected user(s)
            var userIds = selectedUsers.map(function () {
                return this.value;
            }).get();

            $.ajax({
                url: '/book/admin-portal/users/remove-user.php',
                method: 'POST',
                data: {user_ids: userIds},
                dataType: 'json',
                success: function (response) {
                    // Display success alert
                    alert(response.message);

                    // Refresh the user list after removal (assuming fetchUserList is the function to fetch users)
                    fetchUserList();
                },
                error: function (error) {
                    console.error('Error removing user(s):', error);
                }
            });
        }
    } else {
        alert('Please select at least one user to remove.');
    }
}
// Cancel edit and show the user list
function cancelUserEdit() {
        $('#editUserFormSection').hide();
        $('#userList').show();
    }
// Save changes
function saveUserChanges() {
    // Collect form data
    var formData = $('#editUserForm').serialize();

    // Send an AJAX request to save changes
    $.ajax({
        url: '/book/admin-portal/users/add-user.php', // Use the same endpoint for adding and editing
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            // Display success or error alert
            if (response.message) {
                alert(response.message);
            } else if (response.error) {
                alert('Error: ' + response.error);
            }

            // Refresh the user list after saving changes
            fetchUserList();

            // Show the user list and hide the edit form
            $('#editUserFormSection').hide();
            $('#userList').show();
        },
        error: function (error) {
            console.error('Error saving changes:', error);
        }
    });
}
//////////////////////////////////NEWS MANAGEMENT/////////////////////////////////
// Fetch and display the list of news articles
function fetchNewsList() {
    $.ajax({
        url: '/book/admin-portal/news/fetch-news.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Check if the data is not null or undefined
            if (data !== null && data !== undefined) {
                // Clear existing list
                $('#newsList').empty();

                // Display news articles in the list
                if (Array.isArray(data)) {
                    // Check if data is an array before using forEach
                    data.forEach(function (article) {
                        // Append news articles to the list
                        $('#newsList').append('<li class="list-group-item">' +
                            '<input type="checkbox" class="form-check-input" name="selectedNews[]" value="' + article.id + '">' +
                            ' <strong>' + article.headline + '</strong><br>' +
                            '<small>' + formatDate(article.datetime) + '</small>' +
                            '</li>');
                    });
                } else {
                    console.error('Received unexpected data format from the server.');
                }
            } else {
                console.error('Received null or undefined data from the server.');
            }
        },
       error: function (xhr, status, error) {
    console.error('Error fetching news list. Status:', status, 'Error:', error);
}

    });
}
// Add News Section
$(document).ready(function () {
        $('#addNewsForm').submit(function (event) {
            // Prevent the form from submitting in the traditional way
            event.preventDefault();

            // Collect form data
            var formData = new FormData(this);

            // Send an AJAX request to add news
            $.ajax({
                url: '/book/admin-portal/news/add-news.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    // Display success or error alert
                    if (response.message) {
                        alert(response.message);
                    } else if (response.error) {
                        alert('Error: ' + response.error);
                    }

                    // Refresh the news list after adding a news article
                    fetchNewsList();
                },
                error: function (error) {
                    console.error('Error adding news article:', error);
                }
            });
        });
    });
// Edit selected news article
function editSelectedNews() {
        var selectedNews = $("input[name='selectedNews[]']:checked");

        if (selectedNews.length === 1) {
            var newsId = selectedNews.val();

            // Fetch news details for editing
            $.ajax({
                url: '/book/admin-portal/news/fetch-news-details.php',
                method: 'GET',
                data: {news_id: newsId},
                dataType: 'json',
                success: function (newsData) {
                    // Display the news details in the edit form
                    $('#editNewsId').val(newsData.id);

                    // Set values for other fields
                    $.each(newsData, function (key, value) {
                        if (key === 'datetime') {
                            // Format the date and time in yyyy-mm-ddThh:mm format
                            $('#newDatetime').val(value.replace(' ', 'T'));
                        } else if (key === 'article') {
                            // Set the value of newArticle field
                            $('#newArticle').val(value);
                        } else {
                            // Set values for other fields
                            $('#new' + key.charAt(0).toUpperCase() + key.slice(1)).val(value);
                        }
                    });

                    // Hide news list and display the edit form
                    $('#newsList').hide();
                    $('#editNewsFormSection').show();
                },
                error: function (xhr, status, error) {
    console.error('Error fetching news details. Status:', status, 'Error:', error);
}

            });
        } else {
            alert('Please select exactly one news article to edit.');
        }
    }
// Remove selected news article
function removeSelectedNews() {
        var selectedNews = $("input[name='selectedNews[]']:checked");

        if (selectedNews.length > 0) {
            if (confirm('Are you sure you want to remove the selected news article(s)?')) {
                // Proceed with removing the selected news article(s)
                var newsIds = selectedNews.map(function () {
                    return this.value;
                }).get();

                $.ajax({
                    url: '/book/admin-portal/news/remove-news.php',
                    method: 'POST',
                    data: {news_ids: newsIds},
                    dataType: 'json',
                    success: function (response) {
                        // Display success alert
                        alert(response.message);

                        // Refresh the news list after removal
                        fetchNewsList();
                    },
                    error: function (error) {
                        console.error('Error removing news article(s):', error);
                    }
                });
            }
        } else {
            alert('Please select at least one news article to remove.');
        }
    }
// Cancel edit and show the news list
function cancelNewsEdit() {
        $('#editNewsFormSection').hide();
        $('#newsList').show();
    }
// Save changes to news article
function saveNewsChanges() {
        // Collect form data
        var formData = new FormData($('#editNewsForm')[0]);

        // Send an AJAX request to save changes
        $.ajax({
            url: '/book/admin-portal/news/save-news-changes.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                // Display success or error alert
                if (response.message) {
                    alert(response.message);
                } else if (response.error) {
                    alert('Error: ' + response.error);
                }

                // Refresh the news list after saving changes
                fetchNewsList();

                // Show the news list and hide the edit form
                $('#editNewsFormSection').hide();
                $('#newsList').show();
            },
            error: function (error) {
                console.error('Error saving news changes:', error);
            }
        });
    }


//fetchUserList();
//fetchNewsList();

});
</script>
</div>
</body>
</html>
