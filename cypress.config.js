const { defineConfig } = require("cypress");

module.exports = defineConfig({
  video: true,
  videoCompression: true,
  e2e: {
    setupNodeEvents(on, config) {
      on('after:spec', (spec, results) => {
        if (results && results.video) {
          // Do we have failures for any retry attempts?
          const failures = results.tests.some((test) =>
            test.attempts.some((attempt) => attempt.state === 'failed')
          )
          if (!failures) {
            // Move the video if the spec passed and no tests retried
            const oldPath = results.video;
            const newPath = 'videos/' + oldPath.split('/').pop();

            // Use cy.task to perform file operations
            cy.task('moveVideo', { oldPath, newPath })
              .then(() => {
                cy.log(`Moved video from ${oldPath} to ${newPath}`);
              })
              .catch((error) => {
                cy.log(`Error moving video: ${error.message}`);
              });
          }
        }
      })
    },
  },
});
