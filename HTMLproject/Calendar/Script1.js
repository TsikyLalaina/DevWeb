let date = new Date();// get the current date and assign it to variable date
let month = date.getMonth(); //get the month in integer from the variable date
let year = date.getFullYear();//get the year from the variable date

generateCalendar();//first call of the function to generate the calender

function generateCalendar() {

let daysInMonth = new Date(year, month + 1, 0).getDate();//get the number of day in the month using the Date function with the argument (month+1) that is the next month and 0 which is the day before the first day of the selected month. Using the .getDate to return the date value.
let firstDay = new Date(year, month, 1).getDay();//return the first day of the month.
let dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];//Array to convert the days into strings

let calendarDayNames = [];//empty array to contain the daynames in the table.
for (let i = 0; i < 7; i++) {
      calendarDayNames.push(`<th>${dayNames[i]}</th>`);
     }

let calendarContent = [];
for (let i = 0; i < firstDay; i++) {
     calendarContent.push(`<td></td>`);//make space for the previous dates of the month.
     }

let currentDate = new Date();
for (let i = 1; i <= daysInMonth; i++) {//fills the table with the content of the calender while asigning a class to the current date.
    if(year === currentDate.getFullYear() && month === currentDate.getMonth())
       {if(i === currentDate.getDate()){
                calendarContent.push(`<td class = "currentday">${i}</td>`);
            }else{calendarContent.push(`<td>${i}</td>`);}
        }else{
    calendarContent.push(`<td>${i}</td>`);
    }
}


while (calendarContent.length % 7 !== 0) {//Making space for the days of the next month.
     calendarContent.push("<td></td>");
     }

let calendarRows = [];
while (calendarContent.length > 0) {
     calendarRows.push("<tr>" + calendarContent.splice(0, 7).join("") + "</tr>");//split the table into seven columns for each row.
     }

let monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
let dateInfo = `${monthNames[month]} ${year}`;//print the month and year.

//update the calender using the id attributes in the html code.
document.getElementById("dayNames").innerHTML = calendarDayNames.join("");
document.getElementById("CalendarBody").innerHTML = calendarRows.join("");
document.getElementById("dateInfo").textContent = dateInfo;
}

//Add an event listiner for the ellement with the selected id wich is the button here.
document.getElementById("prevMonth").addEventListener("click", function() {
    // Update month and year variables to represent previous month
    if (month === 0) {//if month is january
        month = 11;//previous month is december
        year--;//decrement the year
    } else {
        month--;//Autre, decremente le mois
    }
    // Update calendar display
    generateCalendar();
});
document.getElementById("nextMonth").addEventListener("click", function() {
    if (month === 11) {
        month = 0;
        year++;
    } else {
        month++;
    }
    generateCalendar();
});