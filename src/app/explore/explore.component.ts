/**
 * TODO: Angular page split, Adjust zoom of map, change Modal button to make it link back to the actual recArea
 * TODO: RecAreaModal: 1. recAreaImageUrl, 2. recAreaName, 3. recAreaReviewRating total, 4. recAreaDescription, 5. recArea Location (Ngui map set on location data), 4. activities (from activityTypeId/activityId), 5. recArea-review-list, 6. recArea-review-post
 * TODO: Explore-nav at top of page (to include search filter)
 *
 **/

import {Component, OnInit, ViewChild} from "@angular/core";
import {Status} from "../shared/interfaces/status";
import {RecArea} from "../shared/interfaces/rec.area";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ActivatedRoute, Route, Router} from "@angular/router";
import {RecAreaService} from "../shared/services/rec.area.service";
import {RecAreaModalComponent} from "./recArea-modal/recArea-modal.component";
import {AreaComponent} from "../area/area.component";
import {Activity} from "../shared/interfaces/activity";
import {ActivityService} from "../shared/services/activity.service";

@Component({
	template: require("./explore.template.html")
})

export class ExploreComponent implements OnInit {
	recArea: RecArea;
	recAreas: RecArea[] = [];
	recAreaSearchForm: FormGroup;
	detailedRecArea: RecArea = {
		recAreaId: null,
		recAreaDescription: "",
		recAreaDirections: "",
		recAreaImageUrl: "",
		recAreaLat: "",
		recAreaLong: "",
		recAreaMapUrl: "",
		recAreaName: ""
	};

	clearedRecArea: RecArea = {
		recAreaId: null,
		recAreaDescription: "",
		recAreaDirections: "",
		recAreaImageUrl: "",
		recAreaLat: "",
		recAreaLong: "",
		recAreaMapUrl: "",
		recAreaName: ""
	};
	direction: string = 'horizontal';
	recAreaParameter: string;
	recAreaValue: string;
	private _opened: boolean = true;
	private _toggleSidebar() {
		this._opened = !this._opened;
	}

  activity: Activity = {activityId: null, activityName: null};
  activities: Activity[] = [];
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

	@ViewChild(RecAreaModalComponent) recAreaModalComponent: RecAreaModalComponent;

  constructor(
    private recAreaService: RecAreaService,
    private router: Router,
    private formBuilder: FormBuilder,
    protected activityService: ActivityService
  ) {
		router.onSameUrlNavigation = "reload";
	}

	ngOnInit(): void {
		this.showRecAreas();
		this.recAreaSearchForm = this.formBuilder.group({
			recAreaSearchName: ["", [Validators.maxLength(140), Validators.minLength(1)]]
		});
		// this.loadSearchResults();
    this.getAllActivities();
  }

  getAllActivities() {
    this.activityService.getAllActivities().subscribe(reply => this.activities = reply);
  }

  getSearchResults() {
    this.recAreaService.getRecAreaByActivityId(this.searchValue).subscribe(recAreas => this.recAreas = recAreas);
  }


  setSearchValue(activityId: string) {
    this.searchValue = activityId;
  }

	showRecAreas(): void {
		this.recAreaService.getAllRecAreas()
			.subscribe(recAreas => this.recAreas = recAreas);
	}

	displayRecArea(detailedRecArea: RecArea) {
		this.detailedRecArea = detailedRecArea;
	}

	clicked({target: marker}: any, detailedRecArea: RecArea) {
		this.detailedRecArea = detailedRecArea;
		marker.nguiMapComponent.openInfoWindow('recAreaInfo', marker);

	}

	//resets Rec Area Selection
	resetRecArea() {
		this.detailedRecArea = this.clearedRecArea;
		// marker.nguiMapComponent.closeInfoWindow('recAreaInfo', marker);
	}

	directionsClick() {
		this.router.navigate(["https://www.google.com/maps/dir/?api=1&destination=" + this.detailedRecArea.recAreaLat + this.detailedRecArea.recAreaLong]);
	}


  getRecAreaByRecAreaName(): void {

    this.recAreaService.getRecAreaByRecAreaName(this.recAreaSearchForm.value.recAreaName).subscribe(reply => {
      this.recAreas = reply;
      this.recAreaSearchForm.reset();
    });
  }

  // getAllRecAreas() : void {
  // 	this.recAreaService.getAllRecAreas().subscribe(reply =>{
  // 		this.recAreaSearchForm.reset();
  // 	});
  // }
}

//Search Functions

// getSearchResults() {
//   let searchParameter = this.recAreaSearchForm.value.searchParameter;
//   let searchContent = this.recAreaSearchForm.value.searchContent;
//   this.router.navigate(["/search", "explore" + searchParameter.charAt(0).toUpperCase() + searchParameter.substring(1), searchContent])
//     .then(() => this.loadSearchResults());
//   // this.router.navigate(["search", this.searchForm.value.searchParameter, this.searchForm.value.searchContent])
// }
//
// loadSearchResults() {
//   this.recAreaParameter = this.route.snapshot.params["recAreaParameter"];
//   this.recAreaValue = this.route.snapshot.params["recAreaValue"];
//   if(this.recAreaParameter === "recAreaStatus"){
//   	this.loadStatus(this.recAreaValue);
// 	} else if(this.)
//   // if(this.recAreaParameter === "recAreaStatus"){
//   //   this.loadStatus(this.recAreaValue);
//   // } else if(this.recAreaParameter === "recAreaActivity"){
//   //   this.loadActivity(this.recAreaValue);
//   // } else if(this.recAreaParameter === "recAreaGender"){
//   //   this.loadGender(this.recAreaValue);
//   // } else if(this.recAreaParameter === "recAreaSpecies"){
//   //   this.loadSpecies(this.recAreaValue);
//   // }
// }
//
// // loadActivity(recAreaActivity: string){
// //   this.recAreaService.getRecAreaByRecAreaActivity(recAreaActivity).subscribe(recArea => this.recArea = recAreas);
// // }
//
// loadGender(recAreaGender: string){
//   this.recAreaService.getrecAreaByrecAreaGender(recAreaGender).subscribe(recAreas => this.recAreas = recAreas);
// }
//
// loadSpecies(recAreaSpecies: string){
//   if(recAreaSpecies === "8472") {
//     alert("THE WEAK SHALL PERISH");
//   }
//   this.recAreaService.getrecAreaByrecAreaSpecies(recAreaSpecies).subscribe(recAreas => this.recAreas = recAreas);
// }
//
// loadStatus(recAreaStatus: string){
//   this.recAreaService.getrecAreaByrecAreaStatus(recAreaStatus).subscribe(recAreas => this.recAreas = recAreas);
// }
