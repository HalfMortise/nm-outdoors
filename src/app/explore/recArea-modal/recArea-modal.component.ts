import {Component, Input, OnInit} from "@angular/core";
import {RecAreaService} from "../../shared/services/rec.area.service";
import {ReviewService} from "../../shared/services/review.service";
import {RecArea} from "../../shared/interfaces/rec.area";
import {Review} from "../../shared/interfaces/review";
import {ActivatedRoute} from "@angular/router";

@Component ({
	selector: "recArea-modal",
	template: require("./recArea-modal.template.html")
})

export class RecAreaModalComponent {
	recArea: RecArea = {recAreaId : "", recAreaDescription : "", recAreaDirections : "", recAreaImageUrl : "", recAreaLat : "", recAreaLong : "", recAreaMapUrl : "", recAreaName : ""};
	review: Review;
	reviews: Review[] = [];

	constructor(
		protected recAreaService: RecAreaService,
		// protected reviewService: ReviewService,
		protected route: ActivatedRoute
	) {
}

ngOnit (): void {

}

	recAreaId = this.route.snapshot.params["recAreaId"];
	// reviewRecAreaId = this.route.snapshot.params["reviewRecAreaId"];



	loadRecArea() {
		this.recAreaService.getRecAreaByRecAreaId(this.recAreaId).subscribe(reply => {this.recArea = reply});
	}
}