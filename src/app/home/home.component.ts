import {Component, OnInit} from "@angular/core";
import {Activity} from "../shared/interfaces/activity";
import {ActivityService} from "../shared/services/activity.service";
import {RecAreaService} from "../shared/services/rec.area.service";
import {ActivatedRoute, Route, Router} from "@angular/router";
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
	// searchForm: FormGroup;
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
	activityId = this.route.snapshot.params["activityId"];
	constructor(
		protected activityService: ActivityService,
		protected recAreaService: RecAreaService,
		protected route: ActivatedRoute,
		protected router: Router) {
			this.router.onSameUrlNavigation = "reload";
	}


	ngOnInit() {
		this.getAllActivities();
		this.loadSearchResults();
	}

	getAllActivities() {
		this.activityService.getAllActivities().subscribe(reply => this.activities = reply);
	}

	getSearchResults() {
		this.router.navigate(["/home", "id", this.searchValue])
			.then(() => this.loadSearchResults());
	}

	loadSearchResults() {
		this.activityParameter = this.route.snapshot.params["activityParameter"];
		this.activityValue = this.route.snapshot.params["activityValue"];
		if(this.activityParameter === "id") {
			this.loadRecAreas(this.activityValue);
		}
	};

	// loadActivity(activityId: string){
	// 	this.activityService.getActivity(activityId).subscribe(activity => this.activity = activity);
	// }

	loadRecAreas(activityId: string){
		this.recAreaService.getRecAreaByActivityId(activityId).subscribe(recAreas => this.recAreas = recAreas);

	}

	setSearchValue(activityId: string) {
		this.searchValue = activityId;
	}
}



