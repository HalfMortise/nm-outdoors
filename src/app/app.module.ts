import {NgModule} from "@angular/core";
import {HttpClientModule} from "@angular/common/http";
import {BrowserModule} from "@angular/platform-browser";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [ NgbModule.forRoot(), BrowserModule, HttpClientModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [...appRoutingProviders]
})
export class AppModule {}