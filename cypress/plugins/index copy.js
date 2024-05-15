const { exec } = require('child_process');

module.exports = (on, config) => {
  on('task', {
    runCypressTest({ testName }) {
      return new Promise((resolve, reject) => {
        const command = `npx cypress run --spec cypress/integration/${testName}.spec.js`;
        exec(command, (error, stdout, stderr) => {
          if (error) {
            console.error(`Error executing Cypress test: ${error}`);
            reject(error);
          } else {
            console.log(`Cypress test output: ${stdout}`);
            resolve(stdout);
          }
        });
      });
    }
  });
};
