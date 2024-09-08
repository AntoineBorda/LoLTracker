import Logo from "@/components/svg/logo/loltracker";
import ThemeToggle from "@/components/theme-toggle";
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";
import { Menu, Slash } from "lucide-react";
import * as React from "react";

export default function Navbar({ path }) {
  return (
    <div className="container flex items-center h-16 max-w-screen-2xl">
      <div className="items-center hidden mr-4 md:flex">
        <a className="flex items-center mr-6 space-x-2" href="/">
          <Logo className="w-10 h-10" />
          <span className="hidden font-bold sm:inline-block">LoLTracker</span>
        </a>

        <Breadcrumb>
          <BreadcrumbList>
            <BreadcrumbItem>
              <BreadcrumbLink href={path.ladderPath}>Home</BreadcrumbLink>
            </BreadcrumbItem>
            <BreadcrumbSeparator>
              <Slash />
            </BreadcrumbSeparator>
            <BreadcrumbItem>
              <BreadcrumbLink href={path.ladderPath}>Ladder</BreadcrumbLink>
            </BreadcrumbItem>
          </BreadcrumbList>
        </Breadcrumb>
      </div>

      <button
        className="inline-flex items-center justify-center px-0 py-2 mr-2 text-base font-medium transition-colors rounded-md whitespace-nowrap focus-visible:outline-none focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:text-accent-foreground h-9 hover:bg-transparent focus-visible:bg-transparent focus-visible:ring-0 focus-visible:ring-offset-0 md:hidden"
        type="button"
        aria-haspopup="dialog"
        aria-expanded="false"
        aria-controls="radix-:R16u6la:"
        data-state="closed"
      >
        <Menu />
        <span className="sr-only">Toggle Menu</span>
      </button>

      <div className="flex items-center justify-end flex-1 space-x-2">
        <nav className="flex items-center">
          <ThemeToggle />
        </nav>
      </div>
    </div>
  );
}
