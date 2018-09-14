import {Component, Input, OnInit} from "@angular/core";
import {RecAreaService} from "../../shared/services/rec.area.service";
import {ActivatedRoute, Route, Router} from "@angular/router";
import {RecArea} from "../../shared/interfaces/rec.area";
import {Review} from "../../shared/interfaces/review";
import {ReviewService} from "../../shared/services/review.service";


@Component({
	template: require("./review-list-post.html"),
	selector: "reviews",
})

export class ReviewListPostComponent implements OnInit {
	review: Review;
	reviews: Review[] = [];
	recAreaId = this.route.snapshot.params["recAreaId"];
	recArea: RecArea = {recAreaId : null, recAreaDescription : null, recAreaDirections : null, recAreaImageUrl : null, recAreaLat : null, recAreaLong : null, recAreaMapUrl : null, recAreaName : null};




	constructor(
		protected recAreaService: RecAreaService,
		protected reviewService: ReviewService,
		protected route: ActivatedRoute,
	) {
	}

	ngOnInit() {
		this.recAreaService.getRecAreaByRecAreaId(this.recAreaId);
		this.loadReviews();
	}

	loadReviews(): any {
		if(this.recAreaId !== undefined) {
			this.reviewService.getReviewByRecAreaId(this.recAreaId).subscribe(reviews => this.reviews = reviews);
		}
	}
}