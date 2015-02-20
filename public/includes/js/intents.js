/**
 * Created by house on 17/02/15.
 */
var intents = {
	generic: {
		title: "person_name sent you a request",
		description: "Do you want to accept this request?",
		placeholders: {
			person_name: "api.user.name"
		}
	},
	join_a_group: {
		title: "person_name would like to join group_name",
		description: "And a description of the request"
	}
};

if (phpGets.action == "view") {
	var action = "view";
	var requestId = phpGets.id;
	API.GET(
		'/intent/' + requestId, {},
		function Success(data) {
			var request = data.body.handler;
			buildPage(
				buildText(
					intents[request].title,
					intents[request].placeholders,
					{
						"api": data.body,
						"get": phpGets
					}
				),
				buildText(
					intents[request].description,
					intents[request].placeholders,
					data.body
				)
			);
		},
		function Error(data) {
			if (!request) {
				console.error("That intent doesn't exist!");
			}
			z
			console.error(data);
		}
	);
}
else if (phpGets.action == "request") {
	//do nothing, let php handle it
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

function intentCreate(handler, data) {
	API.POST(
		'/intent',
		{handler: handler, data: data},
		function Success(data) {
			window.history.back();
		},
		function Error(data) {
			console.error(data);
		}
	)
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