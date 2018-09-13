import {Component, OnInit} from "@angular/core";
import {Activity} from "../shared/interfaces/activity";
import {ActivityService} from "../shared/services/activity.service";

@Component({
	template: require("./home.template.html")
})
export class HomeComponent implements OnInit{

	activities : Activity[];

	constructor(protected activityService : ActivityService) {

	}


	ngOnInit() {
	this.getAllActivities();
	}
	getAllActivities() {
		this.activityService.getAllActivities().subscribe(reply => this.activities = reply);
	}
	// this.loadSearchResults();
}

// loadSearchResults() {
// 	this.activityParameter = this.route.snapshot.params["activityParameter"];
// 	this.activityValue = this.route.snapshot.params["activityValue"];
// 	if(this.activityParameter === "activityStatus"){
// 		this.loadStatus(this.activityValue);
// 	} else if(this.activityParameter === "Wild Life Viewing"){
// 		this.load
// 	}
// }