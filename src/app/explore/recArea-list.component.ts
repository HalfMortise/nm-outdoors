import {Component, Input, OnInit} from "@angular/core";
import {RecAreaService} from "../shared/services/rec.area.service";
import {RecArea} from "../shared/interfaces/rec.area";
import {ActivatedRoute} from "@angular/router";
import {NgxPaginationModule} from 'ngx-pagination';


// @module({
// 	imports: [BrowserModule, NgxPaginationModule], // <-- include it in your app module
// 	declarations: [RecAreaListComponent],
// 	bootstrap: [RecAreaListComponent]
// })

@Component ({
	selector: "recArea-list",
	template: require("./recArea-list.html"), 

})

export class RecAreaListComponent implements OnInit {
	@Input() recAreaId: string;
	recArea: RecArea = null;
	recAreas: RecArea[] = [];


	constructor(
		protected recAreaService: RecAreaService,
		protected route: ActivatedRoute
	) {
	}

	ngOnInit() {
		this.recAreaService.getRecAreaByRecAreaId(this.recAreaId) . subscribe(recAreas => this.recArea = recAreas);
		this.loadRecAreas();
	}

	loadRecAreas(): any {
		this.recAreaService.getAllRecAreas() . subscribe(recAreas => this.recArea = recAreas);
	}
}