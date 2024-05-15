{
"model": {
"name": "TestAi",
"table": "test_ais",
"viewPath": "admin",
"controllerNamespace": "Admin"
},
"fields": [
{
"name": "title",
"required": true,
"null": false,
"sort": true,
"dataType": "string",
"index": true,
"search": true,
"cascade": false,
"inputType": "text",
"default": null,
"export": false,
"import": false,
"md3": true,
"md4": false,
"md6": false,
"md12": false
},
{
"name": "name",
"required": true,
"null": false,
"sort": true,
"dataType": "string",
"index": true,
"search": true,
"cascade": false,
"inputType": "text",
"default": null,
"export": false,
"import": false,
"md3": true,
"md4": false,
"md6": false,
"md12": false
}
],
"validations": [
{
"field": "title",
"rules": "required|string|max:255"
},
{
"field": "name",
"rules": "required"
}
],
"addons": {
"softDelete": false,
"generateAPI": true,
"dateFilter": true,
"export": true,
"bulkActivation": false,
"notifications": {
"mail": false,
"site": true
},
"excel": false,
"print": false,
"import": false
},
"media": [
{
"name": "photo",
"required": true,
"size": "10",
"null": true,
"column": "3",
"multi": true
},
{
"name": "video",
"required": true,
"size": "10",
"null": true,
"column": "3",
"multi": true
}
]
}
