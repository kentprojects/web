/**
 * Created by house on 17/02/15.
 */
var intents = {
	generic: {
		title: "person_name sent you a request",
		description: "Do you want to accept this request?",
		placeholders: {
			person_name: "user.name"
		}
	},
	join_a_group: {
		title: "person_name would like to join group_name",
		description: "Do you want to allow person_name to join group_name?",
		placeholders: {
			person_name: "user.name",
			group_name: "group.name"
		}
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
					data.body
				),
				buildText(
					intents[request].description,
					intents[request].placeholders,
					data.body
				)
			);
		},
		function Error(data) {
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
	API.PUT(
		"/intent/" + requestId,
		{state: "accepted"},
		function Success(data) {
			window.location.href = "/dashboard.php";
		},
		function Error(data) {
			console.log("Failed to accept intent: " + data);
		}
	)
}

function declineIntent() {
	API.PUT(
		"/intent/" + requestId,
		{state: "rejected"},
		function Success(data) {
			window.location.href = "/dashboard.php";
		},
		function Error(data) {
			console.log("Failed to reject intent: " + data);
		}
	)
}

function buildPage(title, description) {
	innerTextForQuerySelector("#intentTitle", title);
	innerTextForQuerySelector("#intentDescription", description);
}