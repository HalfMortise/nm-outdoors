/**
 * TODO: Angular page split, Adjust zoom of map, change Modal button to make it link back to the actual recArea
 * TODO: RecAreaModal: 1. recAreaImageUrl, 2. recAreaName, 3. recAreaReviewRating total, 4. recAreaDescription, 5. recArea Location (Ngui map set on location data), 4. activities (from activityTypeId/activityId), 5. recArea-review-list, 6. recArea-review-post
 * TODO: Explore-nav at top of page (to include search filter)
 *
 **/

import {Component, OnInit} from "@angular/core";
import {RecArea} from "../shared/interfaces/rec.area";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {RecAreaService} from "../shared/services/rec.area.service";

@Component({
	template: require("./explore.html")
})

export class ExploreComponent implements OnInit{
	recArea : RecArea;
	recAreas : RecArea[] = [];
	recAreaSearchForm : FormGroup;
	detailedRecArea : RecArea = {recAreaId : "", recAreaDescription : "", recAreaDirections : "", recAreaImageUrl : "", recAreaLat : "", recAreaLong : "", recAreaMapUrl : "", recAreaName : ""};
	direction: string = 'horizontal';


	constructor(private recAreaService: RecAreaService, private router: Router, private formBuilder: FormBuilder){
	}

	ngOnInit() : void {
		this.showRecAreas();
		this.recAreaSearchForm = this.formBuilder.group({
			recAreaSearchName: ["",[Validators.maxLength(140), Validators.minLength(1)]]
		});
	}

	showRecAreas() : void {
		this.recAreaService.getAllRecAreas()
			.subscribe(recAreas => this.recAreas = recAreas);
	}

	clicked({target: marker} : any) {
		marker.nguiMapComponent.openInfoWindow('detailedRecArea', marker);
	}

	displayRecArea(recArea : RecArea) {
		this.recArea = recArea;
	}

	// getAllRecAreas() : void {
	// 	this.recAreaService.getAllRecAreas().subscribe(reply =>{
	// 		this.recAreaSearchForm.reset();
	// 	});
	// }
}