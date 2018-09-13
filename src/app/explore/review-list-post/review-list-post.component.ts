import {Component, Input, OnInit} from "@angular/core";
import {RecAreaService} from "../shared/services/rec.area.service";
import {ActivatedRoute, Route, Router} from "@angular/router";
import {RecArea} from "../shared/interfaces/rec.area";
import {ProfileService} from "../../shared/services/profile.service";
import {Review} from "../../shared/interfaces/review";
import {ReviewService} from "../../shared/services/review.service";

@Component({
	template: require("./review-list-post.html"),
	selector: "review-list",
})

export class RecAreaListComponent implements OnInit {
	@Input() recAreaId: string;
	recAreas: RecArea[] = [];
	recArea: RecArea;
	reviews: Review[] = [];
	review: Review;



	constructor(
		protected recAreaService: RecAreaService,
		protected reviewService: ReviewService,
		protected profileService: ProfileService,
		protected route: ActivatedRoute
	) {
	}

	ngOnInit() {
		this.loadReviews();
	}

	loadReviews(): any {
		this.recAreaService.getAllReviews() . subscribe(reviews => this.reviews = reviews);
	}
}