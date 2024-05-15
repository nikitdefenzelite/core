const fs = require('fs-extra');

module.exports = (on, config) => {
  on('task', {
    moveVideo({ oldPath, newPath }) {
      return new Promise((resolve, reject) => {
        fs.move(oldPath, newPath, { overwrite: true }, (err) => {
          if (err) {
            reject(err);
          } else {
            resolve();
          }
        });
      });
    }
  });
};
