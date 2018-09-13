import {Component, Input, OnInit} from "@angular/core";
import {RecAreaService} from "../../shared/services/rec.area.service";
import {RecArea} from "../../shared/interfaces/rec.area";
import {NgxPaginationModule} from 'ngx-pagination';
import {Status} from "../../shared/interfaces/status";
import {Activity} from "../../shared/interfaces/activity";


@Component ({
	selector: "recArea-list",
	template: require("./recArea-list.template.html"),

})

export class RecAreaListComponent implements OnInit {
	@Input()
	recAreas: RecArea[] = [];
	activities: Activity[] =[];
	status: Status = {status: null, message: null, type: null};

	constructor(
		protected recAreaService: RecAreaService
	) {
	}

	ngOnInit() {
		this.loadRecAreas();
	}

	loadRecAreas(): any {
		this.recAreaService.getAllRecAreas() . subscribe(recAreas => this.recAreas = recAreas);
	}
}