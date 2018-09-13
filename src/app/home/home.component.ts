import {Component, OnInit} from "@angular/core";
import {Activity} from "../shared/interfaces/activity";
import {ActivityService} from "../shared/services/activity.service";
import {RecAreaService} from "../shared/services/rec.area.service";
import {Status} from "../shared/interfaces/status";
import {RecArea} from "../shared/interfaces/rec.area";

@Component({
	template: require("./home.template.html")
})
export class HomeComponent implements OnInit {
	recArea: RecArea;
	recAreas: RecArea[] =[];
	activity: Activity = {activityId: null, activityName: null};
	activities: Activity[] =[];
	searchValue: string;
	status: Status = {status: null, message: null, type: null};
	searchParameters: any [] = [
		{"parameter": "Wildlife Viewing"},
		{"parameter": "Fishing"},
		{"parameter": "Hiking"},
		{"parameter": "Camping"},
		{"parameter": "Water Sports"},
		{"parameter": "Biking"},
		{"parameter": "Winter Sports"},
	];
	activityParameter: string;
	activityValue: string;
	constructor(
		protected activityService: ActivityService,
		protected recAreaService: RecAreaService
	){}


	ngOnInit() {
		this.getAllActivities();
		this.loadSearchResults();
	}

	getAllActivities() {
		this.activityService.getAllActivities().subscribe(reply => this.activities = reply);
	}


	loadSearchResults() {
		if(this.activityParameter === "id") {
			this.loadRecAreas(this.activityValue);
		}
	};


	loadRecAreas(activityId: string){
		this.recAreaService.getRecAreaByActivityId(activityId).subscribe(recAreas => this.recAreas = recAreas);

	}

	setSearchValue(activityId: string) {
		this.searchValue = activityId;
	}
}



