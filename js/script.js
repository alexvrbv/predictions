"use strict";

new Vue({
  el: '#app',
  components: {
    Autocomplete,
  },
  data: {
    // Search function can return a promise
    // which resolves with an array of
    // results.
    search(input) {
      const url = `api/result/read.php?query=${encodeURI(input)}`

      return new Promise(resolve => {
        if (input.length < 3) {
          return resolve([])
        }

        fetch(url)
          .then(response => response.json())
          .then(data => {
            resolve(data.predictions)
          })
      })
    },

    // Возвращаем свойство подсказки 'description'
    getResultValue(result) {
      return result.description
    },

  },
})