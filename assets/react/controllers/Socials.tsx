import Discord from "@/components/svg/social/discord";
import Twitch from "@/components/svg/social/twitch";
import X from "@/components/svg/social/x";
import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Check } from "lucide-react";
import * as React from "react";

export default function CardDemo() {
  return (
    <div className="flex flex-row flex-wrap justify-center gap-8">
      <Card className="w-60 sm:w-72">
        <CardHeader>
          <CardTitle>X</CardTitle>
          <CardDescription>Contact me on X.</CardDescription>
        </CardHeader>
        <CardContent className="grid gap-4">
          <X className="w-28 h-28 sm:w-40 sm:h-40" />
        </CardContent>
        <CardFooter>
          <Button className="w-full">
            <Check className="w-4 h-4 mr-2" />
            Let's Go
          </Button>
        </CardFooter>
      </Card>
      <Card className="w-60 sm:w-72">
        <CardHeader>
          <CardTitle>Discord</CardTitle>
          <CardDescription>Contact me on Discord.</CardDescription>
        </CardHeader>
        <CardContent className="grid gap-4">
          <Discord className="w-28 h-28 sm:w-40 sm:h-40" />
        </CardContent>
        <CardFooter>
          <Button className="w-full">
            <Check className="w-4 h-4 mr-2" />
            Let's Go
          </Button>
        </CardFooter>
      </Card>
      <Card className="w-60 sm:w-72">
        <CardHeader>
          <CardTitle>Twitch</CardTitle>
          <CardDescription>Contact me on Twitch.</CardDescription>
        </CardHeader>
        <CardContent className="grid gap-4">
          <Twitch className="w-28 h-28 sm:w-40 sm:h-40" />
        </CardContent>
        <CardFooter>
          <Button className="w-full">
            <Check className="w-4 h-4 mr-2" />
            Let's Go
          </Button>
        </CardFooter>
      </Card>
    </div>
  );
}
