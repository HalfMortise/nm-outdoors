import {Component, OnInit} from "@angular/core";
import {RecArea} from "../shared/interfaces/rec.area";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {RecAreaService} from "../shared/services/rec.area.service";

@Component({
	template: require("./explore.html")
})

export class ExploreComponent implements OnInit{
	recArea : string = "";
	recAreas : RecArea[] = [];
	recAreaSearchForm : FormGroup;
	detailedRecArea : RecArea = new RecArea(null, null, null, null, null, null, null, null, null);


	constructor(private recAreaService: RecAreaService, private router: Router,private formBuilder: FormBuilder){
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

	clicked({target: marker} : any, recArea : RecArea) {
		this.detailedRecArea = recArea;
		marker.nguiMapComponent.openInfoWindow('detailedRecArea', marker);
	}

	getAllRecAreas() : void {
		this.recAreaService.getAllRecAreas(this.recAreaSearchForm.value.recAreaSearchName).subscribe(reply =>{
			this.recAreas=reply;
			this.recAreaSearchForm.reset();
		});
	}
}