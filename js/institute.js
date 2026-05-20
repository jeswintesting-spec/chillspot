(function() {
  // Determine baseUrl dynamically based on the location of this script
  let baseUrl = '/chillspot/';
  if (document.currentScript) {
    const scriptSrc = document.currentScript.src;
    const idx = scriptSrc.indexOf('/js/institute.js');
    if (idx !== -1) {
      baseUrl = scriptSrc.substring(0, idx) + '/';
    }
  }

  fetch(baseUrl + 'get_institute.php')
    .then(response => response.json())
    .then(data => {
      if (data && data.institute_name) {
        const name = data.institute_name;
        if (name === 'CUCEK') return; // Default is already CUCEK, nothing to replace

        // 1. Update Document Title
        document.title = document.title.replace(/CUCEK/g, name);

        // 2. Traverse DOM and replace visible text nodes
        function replaceInNode(node) {
          if (node.nodeType === Node.TEXT_NODE) {
            if (node.nodeValue.includes("CUCEK")) {
              node.nodeValue = node.nodeValue.replace(/CUCEK/g, name);
            }
          } else {
            // Ignore script, style, iframe, and form elements where text changes might affect scripts
            if (node.nodeName !== 'SCRIPT' && node.nodeName !== 'STYLE' && node.nodeName !== 'TEXTAREA') {
              for (let child of node.childNodes) {
                replaceInNode(child);
              }
            }
          }
        }

        // Apply replacement when the body is loaded
        if (document.body) {
          replaceInNode(document.body);
        } else {
          document.addEventListener('DOMContentLoaded', () => {
            replaceInNode(document.body);
          });
        }
      }
    })
    .catch(err => console.error("Error loading institute settings:", err));
})();
