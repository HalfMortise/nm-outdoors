import {Component, Input, OnInit} from "@angular/core";
import {RecAreaService} from "../../shared/services/rec.area.service";
import {RecArea} from "../../shared/interfaces/rec.area";
import {ActivatedRoute} from "@angular/router";
import {NgxPaginationModule} from 'ngx-pagination';
import {Status} from "../../shared/interfaces/status";
import {Activity} from "../../shared/interfaces/activity";


// @module({
// 	imports: [BrowserModule, NgxPaginationModule], // <-- include it in your app module
// 	declarations: [RecAreaListComponent],
// 	bootstrap: [RecAreaListComponent]
// })

@Component ({
	selector: "recArea-list",
	template: require("./recArea-list.template.html"),

})

export class RecAreaListComponent implements OnInit {
	@Input() recAreaId: string;
	recAreas: RecArea[] = [];
	recArea: RecArea;
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
		protected recAreaService: RecAreaService,
		protected route: ActivatedRoute
	) {
	}

	ngOnInit() {
		this.loadRecAreas();
	}

	loadRecAreas(): any {
		this.recAreaService.getAllRecAreas() . subscribe(recAreas => this.recAreas = recAreas);
	}
}