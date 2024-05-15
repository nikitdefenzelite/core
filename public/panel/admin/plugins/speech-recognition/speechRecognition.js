var micLock = 0;
var activeTextarea = null;

function activateLisener(){
     $('#AddSpeechText').modal('show');
}

$('textarea').click(function(){
   if(micLock == 0){
    activeTextarea = $(this);
    $('#activateMic').remove();
    floatBtn = "<div id='activateMic' onclick='activateLisener()'> <i class='fa fa-microphone'></i> </div>";
    micLock = 1;
    $(this).before(floatBtn);
   }
});

$('#addText-VoiceCommand').click(function(){
    text = $('#said').val();
    activeTextarea.val(activeTextarea.val()+' '+text);
    text = $('#said').val('');
    text = $('#output_result').html('');
    $('#AddSpeechText').modal('hide');
    micLock = 0;
}); 

$('.speech-pulse').addClass('d-none');

"use strict";
const log = document.querySelector(".output_log");
const output = document.querySelector(".output_result");

const SpeechRecognition =
  window.SpeechRecognition || window.webkitSpeechRecognition;
const recognition = new SpeechRecognition();

recognition.interimResults = true;
recognition.maxAlternatives = 1;

// document.querySelector("#start-activateMic").addEventListener("click", () => {
//   let recogLang = document.querySelector("[name=lang]:checked");
//   recognition.lang = recogLang.value;
//   recognition.start();
// });
document.querySelector("#restart-activateMic").addEventListener("click", () => {
  let recogLang = document.querySelector("[name=lang]:checked");
  recognition.lang = recogLang.value;
  recognition.start();
  $('.speech-pulse').removeClass('d-none');
});

recognition.addEventListener("speechstart", () => {
  log.textContent = "Speech has been detected.";
});

recognition.addEventListener("result", (e) => {
  log.textContent = "Result has been detected.";

  let last = e.results.length - 1;
  let text = e.results[last][0].transcript;

  output.textContent = text;
 
  

  log.textContent = "Confidence: " + e.results[0][0].confidence;
});

recognition.addEventListener("speechend", () => {
  recognition.stop();
  var old_said = $("#said").val();
  $("#said").val(old_said+' '+output.textContent);
    $("#speech_text").val(old_said+' '+output.textContent);
    $('.speech-pulse').addClass('d-none');
});

recognition.addEventListener("error", (e) => {
  output.textContent = "Error: " + e.error;
});

function synthVoice(text, lang) {
  const synth = window.speechSynthesis;
  const utterance = new SpeechSynthesisUtterance();
  utterance.lang = lang;
  utterance.text = text;
  synth.speak(utterance);
}

// document.querySelector(".speak").addEventListener("click", () => {
//   let i = document.querySelector(".en");
//   let text = i.value || i.placeholder;
//   synthVoice(text, "en-US");
// });

// document.querySelector(".speak_jp").addEventListener("click", () => {
//   let i2 = document.querySelector(".jp");
//   let text2 = i2.value || i2.placeholder;
//   synthVoice(text2, "ja-JP");
// });
