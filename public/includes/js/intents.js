/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
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
	},
	invite_to_group: {
		title: "person_name would like you to join group_name",
		description: "Do you want to join group_name?",
		placeholders: {
			person_name: "group.creator.name",
			group_name: "group.name"
		}
	},
	undertake_a_project: {
		title: "group_name would like to undertake project_name",
		description: "Do you want to allow group_name to undertake project_name?",
		placeholders: {
			group_name: "group.name",
			project_name: "project.name"
		}
	},
	access_year: {
		title: "person_name would like to access the current year",
		description: "Do you want to allow person_name to access the current year?",
		placeholders: {
			person_name: "user.name"
		}
	}
};

if (phpGets.action == "view") {
	var action = "view";
	var requestId = phpGets.id;
	API.GET(
		'/intent/' + requestId, {},
		function Success(data) {
			if (data.body.state == "open"){
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
				document.querySelector(".btn-group").style.display = "block";
			}
			else {
				buildPage(
					"You can't do that again!",
					"You've already responded to this notification"
				);
			}
		},
		function Error(data) {
			if (data.status == 403) {
				buildPage(
					"This message isn't meant for you!",
					"Either you're being nosy, or something\'s gone wrong."
				)
			}
			if (data.status == 404) {
				buildPage(
					"Oops!",
					"Whatever you're looking for isn't there, yet."
				)
			}
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

function intentCreate(handler, data, redirectUrl) {
	API.POST(
		'/intent',
		{handler: handler, data: data},
		function Success(data) {
			if (redirectUrl) {
				window.location.href = redirectUrl;
			}
			else {
				window.history.back();
			}
		},
		function Error(data) {
			console.error(data);
		}
	)
}

function intentAccept() {
	API.PUT(
		"/intent/" + requestId,
		{state: "accepted"},
		function Success(data) {
			window.location.href = "/dashboard.php";
		},
		function Error(data) {
			console.log("Failed to accept intent: ");
			console.log(data);
		}
	)
}

function intentDecline() {
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
	qf("#intentTitle", function (element) {
		element.innerText = title;
	});
	qf("#intentDescription", function (element) {
		element.innerText = description;
	});
}