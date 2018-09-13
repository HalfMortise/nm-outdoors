import {Component, Input, OnInit} from "@angular/core";
import {RecAreaService} from "../../shared/services/rec.area.service";
import {ActivatedRoute, Route, Router} from "@angular/router";
import {RecArea} from "../../shared/interfaces/rec.area";
import {ProfileService} from "../../shared/services/profile.service";
import {Review} from "../../shared/interfaces/review";
import {ReviewService} from "../../shared/services/review.service";


@Component({
	template: require("./review-list-post.html"),
	selector: "review-list",
})

export class ReviewListPostComponent implements OnInit {
	review: Review;
	reviews: Review[] = [];
	recAreaId = this.route.snapshot.params["recAreaId"];
	recArea: RecArea = {recAreaId : "", recAreaDescription : "", recAreaDirections : "", recAreaImageUrl : "", recAreaLat : "", recAreaLong : "", recAreaMapUrl : "", recAreaName : ""};




	constructor(
		protected recAreaService: RecAreaService,
		protected reviewService: ReviewService,
		protected profileService: ProfileService,
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