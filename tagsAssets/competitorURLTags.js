const ul_URL = document.querySelector(".exampleURL"),
  input_URL = document.querySelector(".input_exampleURL");
tags_URL = [];

getMerchantBrandsURL();
showTagURL();
function getMerchantBrandsURL() {
  $.ajax({
    type: "GET",
    url: "load_competitor_urls.php",
    data: {},
    async: false,
    success: function (data) {
      console.log(data);
      if (data != "empty") {
        $.each(JSON.parse(data), function (k, val) {
          console.log(val);
          tags_URL.push(val);
        });
      } else {
        console.log("empty");
        tags_URL = [];
      }
    },
  });
}
function showTagURL() {
  ul_URL.querySelectorAll("li").forEach((li) => li.remove());
  tags_URL
    .slice()
    .reverse()
    .forEach((tag) => {
      let liTag = `<li>${tag} <i class="uit uit-multiply" onclick="removeURL(this, '${tag}')"></i></li>`;
      ul_URL.insertAdjacentHTML("afterbegin", liTag);
    });
}
function createTagURL() {
  ul_URL.querySelectorAll("li").forEach((li) => li.remove());
  tags_URL
    .slice()
    .reverse()
    .forEach((tag) => {
      let liTag = `<li>${tag} <i class="uit uit-multiply" onclick="removeURL(this, '${tag}')"></i></li>`;
      ul_URL.insertAdjacentHTML("afterbegin", liTag);
    });

  $.ajax({
    type: "POST",
    url: "save_competitor_url.php",
    data: {
      UpdatedURLs: tags_URL,
    },
    success: function (data) {
      console.log(data);

      $(".URLmessage_box").html(data);
      $(".URLmessage_box").addClass("alert alert-success");
      $(".URLmessage_box").show();
      setTimeout(function () {
        $(".URLmessage_box").hide();
      }, 3000);
    },
  });
}

function removeURL(element, tag) {
  console.log("remove function called...");
  let index = tags_URL.indexOf(tag);
  tags_URL = [...tags_URL.slice(0, index), ...tags_URL.slice(index + 1)];
  element.parentElement.remove();
  console.log("tags_URL ", tags_URL);
  $.ajax({
    type: "POST",
    url: "save_competitor_url.php",
    data: {
      UpdatedURLs: tags_URL,
    },
    success: function (data) {
      console.log(data);
      $(".URLmessage_box").html("Competitor URL Removed Successfully! ");
      $(".URLmessage_box").addClass("alert alert-success");
      $(".URLmessage_box").show();
      setTimeout(function () {
        $(".URLmessage_box").hide();
      }, 3000);
    },
  });
}
function addTagURL(e) {
  if (e.key == "Enter") {
    console.log("addtagURL called with Enter key pressed");

    // Remove whitespace from the input value
    let latestTag = e.target.value.replace(/\s/g, "");

    // Convert the tag to lowercase
    let tag = latestTag.toLowerCase();

    // Validate the input URL
    let validationFlag = validateInputURL(tag);

    // Check if the tag is "false" or "true"
    if (tag == "false" || tag == "true") {
      alert("The words True/False are not allowed!");
    }
    // Check if the validation flag is true
    else if (validationFlag) {
      console.log("Duplicate tag check for ", tag);
      // Remove the protocol and other parts from the original tag
      var modifiedTag = tag.replace(/^(?:https?:\/\/)?(?:www\.)?/, "");
      modifiedTag = modifiedTag.replace(/\/.*|\?.*|#.*/, "");
      // To remove special characters from start and end of Url string
      let sanitized_input = removeSpecialCharactersFromURL(modifiedTag);
      console.log("Sanitized Url ", sanitized_input);

      // Check if the tag is not empty and is not already present in tags_URL array
      if (sanitized_input.length > 1 && !tags_URL.includes(sanitized_input)) {
        // Split the tag by commas if there are multiple tags
        // tag.split(",").forEach((tag) => {

        console.log("Original URL: ", tag);
        console.log("Modified URL: ", modifiedTag);

        createAnchor_TagURL(sanitized_input);
        tags_URL.push(sanitized_input);
        createTagURL();
        // });
      }
    }

    // Reset the value of the input element
    e.target.value = "";
  }
}

function createAnchor_TagURL(modifiedTag) {
  var anchor = $("<a></a>")
    .attr({
      href: "https://www." + modifiedTag,
      target: "_blank",
    })
    .text(modifiedTag);

  var paragraph = $("<p></p>").append(anchor);
  var column = $("<div></div>").addClass("col-md-4").append(paragraph);

  $("#responseUrl").append(column);
}

function validateInputURL(url) {
  // Add "https://" if not specified by the user
  if (!/^https?:\/\//i.test(url)) {
    url = "https://" + url;
  }
  // Regular expression to match URL pattern
  // var urlPattern = /^(http[s]?:\/\/)?([w]{3}\.)?([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})(\/\S*)?$/;
  var urlPattern =
    /^(http[s]?:\/\/)?([w]{3}\.)?([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})(\/\S*)?$/;

  // Check if the URL matches the pattern and includes the protocol and domain extension
  if (url.match(urlPattern) && url.includes(".") && (url.includes("http://") || url.includes("https://"))) {
    // URL is valid
    return true;
  }
   else {
    // URL is invalid
    var msg = "Please enter a valid URL.";
    // Display error message on the page
    $(".URLmessage_box").html(msg).addClass("alert alert-danger").show();

    // Hide the error message after 8 seconds
    setTimeout(function () {
      $(".URLmessage_box").removeClass("alert alert-danger").hide();
    }, 8000);

    return false;
  }
}

function removeSpecialCharactersFromURL(url) {
  // Remove special characters from the start and end of the URL
  var sanitizedURL = url.replace(/^[^a-zA-Z0-9]+|[^a-zA-Z0-9]+$/g, "");

  // Remove all special characters except "." from the domain name
  var sanitizedURL = sanitizedURL.replace(/[^a-z0-9.]/gi, "");

  return sanitizedURL;
}

input_URL.addEventListener("keyup", addTagURL);
