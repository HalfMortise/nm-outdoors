import {Component, Input, OnInit} from "@angular/core";
import {RecAreaService} from "../shared/services/rec.area.service";
import {RecArea} from "../shared/interfaces/rec.area";
import {ActivatedRoute} from "@angular/router";

@Component ({
	selector: "recArea-list",
	template: require("./review-list-post.template.html")
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