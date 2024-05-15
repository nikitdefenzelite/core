Cypress.Commands.add('runCypressTest', testName => {
    return cy.task('runCypressTest', { testName });
  });
  

  Cypress.Commands.add('typeInCkEditor', (selector, content) => {
    // Wait for the editor to be visible and then type into it
    cy.get(selector, { timeout: 10000 }).should($el => {
      expect($el).to.exist;
      const editorInstance = $el[0].ckeditorInstance;
      expect(editorInstance).to.exist;
      editorInstance.setData(content);
    });
  });

  Cypress.Commands.add('uploadImageFromUrl', (url, selector) => {
    return cy.request(url, { responseType: 'blob' }).then(response => {
      const blob = response.body;
      const fileName = url.substring(url.lastIndexOf('/') + 1);
      const fileType = blob.type;
  
      const testFile = new File([blob], fileName, { type: fileType });
  
      cy.get(selector).then(input => {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(testFile);
        input[0].files = dataTransfer.files;
        input.trigger('change', { force: true });
      });
    });
  });


  Cypress.Commands.add("generateLorem", () => {
    // Lorem Ipsum text
    const loremIpsum = "Loremipsumdolorsitamet,consecteturadipiscingelit.Seddoeiusmodtemporincididuntutlaboreetdoloremagnaaliqua.Utenimadminimveniam,quisnostrudexercitationullamcolaborisnisiutaliquipexeacommodoconsequat.Duisauteiruredolorinreprehenderitinvoluptatevelitessecillumdoloreeufugiatnullapariatur.Excepteursintoccaecatcupidatatnonproident,suntinculpaquiofficiadeseruntmollitanimidestlaborum.";

    // Get a random starting index within the range of the Lorem Ipsum text
    const startIndex = Math.floor(Math.random() * (loremIpsum.length - 10));

    // Extract 10 characters from the Lorem Ipsum text starting from the random index
    const loremText = loremIpsum.substr(startIndex, 10);

    // Return the generated Lorem Ipsum text
    return cy.wrap(loremText);
});


  Cypress.Commands.add("typeInCkEditorClear", (selector) => {
    cy.get(selector).clear();
});


Cypress.Commands.add("getFirstRecordId", { prevSubject: 'element' }, (subject) => {
  // Here, subject refers to the element that the custom command was chained off of
  return cy.wrap(subject).find('table#paragraphTable tbody tr').first().then(($row) => {
    // Return the ID of the first row
    return $row.attr('id');
  });
});



Cypress.Commands.add("generateUniqueAlphaNumeric", (length) => {
    const characters = 'abcdefghijklmnopqrstuvwxyz';
    // const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return cy.wrap(result);
});


// <---------------------------Start Helper -------------------------------->

const codeArray = ['title_name', 'item_name', 'item_value'];
const nameArray = ['mayank', 'arun', 'ayush'];
const emailArray = ['title_name@gmail.com', 'item_name@gmail.com', 'item_value@gmail.com'];
const firstNameArray = ['title_nameasdjas', 'item_nadsadame', 'iadsdasdtem_value'];

//Example:
//
// cy.getRandom(arrayName).then(randomItem => {
//   cy.log('Random Value:', randomItem);
// });
//
//
Cypress.Commands.add('getRandom', (arrayName) => {
  let selectedArray;
  switch(arrayName) {
    case 'code':
      selectedArray = codeArray;
      break;
    case 'name':
      selectedArray = nameArray;
      break;
    case 'email':
      selectedArray = emailArray;
      break;
    case 'firstName':
      selectedArray = firstNameArray;
      break;
    default:
      selectedArray = codeArray;
  }
  const randomIndex = Math.floor(Math.random() * selectedArray.length);
  return cy.wrap(selectedArray[randomIndex]);
});




// <---------------------------End Helper ---------------------------------->