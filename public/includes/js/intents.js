/**
 * Created by house on 17/02/15.
 */
var intents = {
	generic: {
		request: {
			title: "Send a request to person_name?",
			description: "Do you want to send a generic request to person_name?",
			placeholders: {
				person_name: "id"
			}
		},
		view: {
			title: "person_name sent you a request",
			description: "Do you want to accept this request?",
			placeholders: {
				person_name: "id"
			}
		}
	},
	join_a_group: {
		request: {
			title: "Ask to join group_name?",
			description: "And a description of the request",
			placeholders: {
				group_name: "group.name",
				person_name: "user.name"
			}
		},
		view: {
			title: "person_name would like to join group_name",
			description: "And a description of the request"
		}
	}
};

function buildText(text, placeholders, data) {
	var processedText = text;
	var replacementStrings = mapPlaceHolders(placeholders, data);
	for(var key in replacementStrings) {
		if (replacementStrings.hasOwnProperty(key)) {
			var replacementString = replacementStrings[key];
			processedText = processedText.replace(key, replacementString);
		}
	}
	return processedText;
}

if (phpGets.action == "view") {
	var action = "view";
	var requestId = phpGets.id;
	API.GET(
		'/intent/' + requestId, {},
		function Success(data) {
			var request = data.body.handler;
			var title = intents[request][action].title;
			var description = intents[request][action].description;
			var placeholders = intents[request][action].placeholders;
			buildPage(
				buildText(
					description,
					placeholders,
					data.body
				),
				buildText(
					title,
					placeholders,
					data.body
				)
			);
		},
		function Error(data) {
			if (!request) {
				console.error("That intent doesn't exist!");
			}z
			console.error(data);
		}
	);
}
else if (phpGets.action == "request") {
	var action = "request";
	var request = phpGets.request;
	var title = intents[request][action].title;
	var description = intents[request][action].description;
	var placeholders = intents[request][action].placeholders;
	console.log(placeholders);
	buildPage(
		buildText(
			title,
			placeholders,
			phpGets
		),
		buildText(
			description,
			placeholders,
			phpGets
		)
	);
	console.log(placeholders);
}
else {
	console.error("That action doesn't exist")
}

function intentReply(response) {
	console.log(response);
	if (response == "accept") {
		state = "accepted"
	}
	if (response == "decline") {
		state = "declined"
	}
	else {
		console.error("invalid response state");
	}
	API.PUT(
		"/intent/" + requestId,
		{"state": state},
		function Success(data) {
			console.log(data);
		},
		function Error(data) {
			console.error(data);
		}
	);
}

function intentCreate(request, data) {
	//TODO: Don't hard-code this
	data = {"something": "Some Value"};
	var json = {"handler": request, "data": data};
	API.POST(
		'/intent',
		json,
		function Success(data) {
			window.history.back();
		},
		function Error(data) {
			console.error(data);
		}
	)
}

function confirmRequest() {
	console.log("Request Confirmed");
};

function cancelRequest() {
	console.log("Request Cancelled");
}

function acceptIntent() {
	console.log("Intent Accepted");
	//intentReply(response);
}

function declineIntent() {
	console.log("Intent Declined");
}

function buildPage(title, description) {
	innerTextForQuerySelector("#intentTitle", title);
	innerTextForQuerySelector("#intentDescription", description);
}