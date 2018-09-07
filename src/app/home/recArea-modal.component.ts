import {Component, OnInit} from "@angular/core";
import {RecAreaService} from "../shared/services/rec.area.service";
import {ReviewService} from "../shared/services/review.service";
import {RecArea} from "../shared/interfaces/rec.area";
import {Review} from "../shared/interfaces/review";
import {ActivatedRoute} from "@angular/router";

@Component ({
	selector: "recArea-modal",
	template: require("./recArea-modal.template.html")
})

export class RecAreaModalComponent implements OnInit {

	recArea: RecArea = null;
	review: Review = null;
	reviews: Review[] = [];

	constructor(
		protected recAreaService: RecAreaService,
		protected reviewService: ReviewService,
		protected route: ActivatedRoute
	) {
	}

	recAreaId = this.route.snapshot.params["recAreaId"];
	reviewRecAreaId = this.route.snapshot.params["reviewRecAreaId"];

	ngOnInit() {
		this.recAreaService.getRecAreaByRecAreaId(this.recAreaId) . subscribe(recArea => this.recArea = recArea);
		this.reviewService.getReviewbyRecAreaId(this.reviewRecAreaId) . subscribe(reviews => this.reviews = reviews);
	}
}