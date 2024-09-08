import {Button} from "@/components/ui/button";
import {ArrowDownNarrowWide, ArrowUpNarrowWide, Percent} from "lucide-react";
import * as React from "react";

export default function Filter({filterProps}) {
    return (
        <div className="flex flex-col sm:flex-row">
            <div className="flex justify-center space-x-1 sm:space-x-1">
                <Button className="w-8 h-8 p-1 sm:w-12 sm:h-12" variant="outline">
                    <img src={filterProps.bottom} alt="filter bottom"/>
                </Button>
                <Button className="w-8 h-8 p-1 sm:w-12 sm:h-12" variant="outline">
                    <img src={filterProps.jungle} alt="filter jungle"/>
                </Button>
                <Button className="w-8 h-8 p-1 sm:w-12 sm:h-12" variant="outline">
                    <img src={filterProps.middle} alt="filter middle"/>
                </Button>
                <Button className="w-8 h-8 p-1 sm:w-12 sm:h-12" variant="outline">
                    <img src={filterProps.top} alt="filter top"/>
                </Button>
                <Button className="w-8 h-8 p-1 sm:w-12 sm:h-12" variant="outline">
                    <img src={filterProps.utility} alt="filter utility"/>
                </Button>
            </div>
            <div className="flex justify-start mt-1 space-x-1 sm:justify-center sm:mt-0 ms:0 sm:ms-8 sm:space-x-1">
                <Button className="w-8 h-8 p-1 sm:w-12 sm:h-12" variant="outline">
                    <ArrowDownNarrowWide/>
                </Button>
                <Button className="w-8 h-8 p-1 sm:w-12 sm:h-12" variant="outline">
                    <ArrowUpNarrowWide/>
                </Button>
                <Button className="w-8 h-8 p-1 sm:w-12 sm:h-12" variant="outline">
                    <Percent/>
                </Button>
            </div>
        </div>
    );
}
