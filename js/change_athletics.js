$(document).on("click", "input[name='newrecord[]']", function () {
  console.log("click");
  const form = document.createElement("form");
  var url = "../model/change_record_category.php";
  form.setAttribute("method", "post");
  form.setAttribute("action", url);
  form.setAttribute("target", "popup test");
  var name = "popup test";
  var option =
    "width = 500, height = 500, top = 100, left = 200, location = no";
  window.open("", name, option);
  const hidden_name = document.createElement("input");
  hidden_name.setAttribute("type", "hidden");
  hidden_name.setAttribute("name", "athlete_name");
  hidden_name.setAttribute("value", $(this).attr("ath"));
  form.appendChild(hidden_name);
  const hidden_sports = document.createElement("input");
  hidden_sports.setAttribute("type", "hidden");
  hidden_sports.setAttribute("name", "schedule_sports");
  hidden_sports.setAttribute("value", $(this).attr("sports"));
  const hidden_id = document.createElement("input");
  hidden_id.setAttribute("type", "hidden");
  hidden_id.setAttribute("name", "schedule_id");
  hidden_id.setAttribute("value", $(this).attr("schedule_id"));
  form.appendChild(hidden_id);
  form.appendChild(hidden_sports);
  document.body.appendChild(form);
  form.submit();
});
