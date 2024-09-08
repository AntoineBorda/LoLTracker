import { Button } from "@/components/ui/button";
import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from "@/components/ui/collapsible";
import { ChevronsUpDown } from "lucide-react";
import * as React from "react";

const LOCAL_STORAGE_KEY = "collapsibleState";

export default function Tracker({ trackerProps }) {
  const [openIndexes, setOpenIndexes] = React.useState(
    () =>
      JSON.parse(localStorage.getItem(LOCAL_STORAGE_KEY)) ||
      Array(trackerProps.length).fill(true)
  );

  React.useEffect(() => {
    localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(openIndexes));
  }, [openIndexes]);

  const toggleCollapsible = (index) => {
    setOpenIndexes((prevOpenIndexes) => {
      const newOpenIndexes = [...prevOpenIndexes];
      newOpenIndexes[index] = !newOpenIndexes[index];
      return newOpenIndexes;
    });
  };

  return (
    <>
      {trackerProps.map((tracker, index) => (
        <Collapsible
          key={index}
          open={openIndexes[index]}
          className="w-[350px] space-y-2"
        >
          <div className="flex items-center justify-between px-4 space-x-4">
            <h4 className="text-sm font-semibold">{tracker.date}</h4>
            <CollapsibleTrigger asChild>
              <Button
                variant="ghost"
                size="sm"
                className="p-0 w-9"
                onClick={() => toggleCollapsible(index)}
              >
                <ChevronsUpDown className="w-4 h-4" />
                <span className="sr-only">Toggle</span>
              </Button>
            </CollapsibleTrigger>
          </div>
          <CollapsibleContent className="space-y-2">
            {tracker.win.map((winStatus, winIndex) => (
              <div
                key={winIndex}
                className={`px-4 py-3 font-mono text-sm border rounded-md ${
                  winStatus ? "border-green-500" : "border-red-500"
                }`}
              >
                <p>{winStatus ? "Win" : "Lose"}</p>
              </div>
            ))}
          </CollapsibleContent>
        </Collapsible>
      ))}
    </>
  );
}
