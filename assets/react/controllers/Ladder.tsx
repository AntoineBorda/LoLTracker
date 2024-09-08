import { CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import BigPicture from "bigpicture";
import * as React from "react";

export default function Ladder({ ladderProps }) {
  const handleBigPicture = (event, imgSrc) => {
    event.preventDefault();
    BigPicture({
      el: event.target,
      imgSrc,
      noLoader: true,
    });
  };
  return (
    <>
      <CardHeader>
        <CardTitle>Ladder</CardTitle>
        <CardDescription>
          Discover the #EUW Solo/Duo queue pro rankings
        </CardDescription>
      </CardHeader>

      <Table>
        <TableHeader>
          <TableRow>
            <TableHead className="px-2 py-3">#</TableHead>
            <TableHead className="px-2 py-3 text-center sm:text-start">
              Player
            </TableHead>
            <TableHead className="px-2 py-3 text-center">Role</TableHead>
            <TableHead className="px-2 py-3 text-center">Fav</TableHead>
            <TableHead className="px-2 py-3 text-center">Elo</TableHead>
            <TableHead className="px-2 py-3 text-center">W/L</TableHead>
            <TableHead className="px-2 py-3 text-center">WR</TableHead>
            <TableHead className="px-2 py-3 text-center">Team</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          {ladderProps.map((ladderProps, index) => (
            <TableRow key={index}>
              {/* Ranking */}
              <TableCell className="px-2 py-3 font-medium">
                {ladderProps.ranking}
              </TableCell>

              {/* Player */}
              <TableCell className="px-2 py-3">
                <div className="flex flex-col items-center sm:flex-row">
                  {/* Image */}
                  {ladderProps.image ? (
                    <a
                      href="#"
                      onClick={(event) =>
                        handleBigPicture(event, ladderProps.image)
                      }
                    >
                      <img
                        src={ladderProps.image}
                        className="object-cover w-8 h-8 mb-2 sm:w-12 sm:h-12 md:w-16 md:h-16 sm:mb-0 sm:mr-2"
                        alt="player picture"
                      />
                    </a>
                  ) : null}
                  {/* Flag */}
                  <TooltipProvider>
                    <Tooltip>
                      <TooltipTrigger>
                        {ladderProps.flag ? (
                          <img
                            className="object-contain w-4 h-4 mr-2 sm:w-6 sm:h-6"
                            src={ladderProps.flag}
                            alt={ladderProps.country}
                          />
                        ) : null}
                      </TooltipTrigger>
                      <TooltipContent>{ladderProps.country}</TooltipContent>
                    </Tooltip>
                  </TooltipProvider>
                  <div className="flex flex-col items-center justify-center sm:flex-row sm:items-center sm:justify-center">
                    {/* SummonerName & RiotID */}
                    <a href={ladderProps.trackerPath}>
                      <span className="block text-center sm:text-left">
                        <span className="block text-lg font-medium sm:inline">
                          {ladderProps.summonerName}
                        </span>
                        <span className="hidden text-lg sm:inline"> | </span>
                        <span className="block text-sm sm:inline text-slate-400">
                          {ladderProps.riotID}
                        </span>
                      </span>
                    </a>
                  </div>
                </div>
              </TableCell>

              {/* Role */}
              <TableCell className="px-2 py-3 text-center">
                <TooltipProvider>
                  <Tooltip>
                    <TooltipTrigger>
                      {ladderProps.roleImage ? (
                        <img
                          className="inline-block object-contain w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10"
                          src={ladderProps.roleImage}
                          alt={ladderProps.role}
                        />
                      ) : null}
                    </TooltipTrigger>
                    <TooltipContent>{ladderProps.role}</TooltipContent>
                  </Tooltip>
                </TooltipProvider>
              </TableCell>

              {/* Favorites Champions */}
              <TableCell className="px-2 py-3 text-center">
                {ladderProps.favoritesChampions &&
                ladderProps.favoritesChampions.length > 0
                  ? ladderProps.favoritesChampions.map(
                      (champion, champIndex) => (
                        <div
                          key={champIndex}
                          className="inline-block me-1 sm:me-2"
                        >
                          <TooltipProvider>
                            <Tooltip>
                              <TooltipTrigger>
                                <img
                                  className="inline-block object-contain w-6 h-6 sm:w-8 sm:h-8"
                                  src={champion.image}
                                  alt={champion.name}
                                />
                              </TooltipTrigger>
                              <TooltipContent>{champion.name}</TooltipContent>
                            </Tooltip>
                          </TooltipProvider>
                        </div>
                      )
                    )
                  : null}
              </TableCell>

              {/* Elo */}
              <TableCell className="px-2 py-3 text-center">
                <TooltipProvider>
                  <Tooltip>
                    <TooltipTrigger>
                      {ladderProps.tierImage ? (
                        <img
                          className="inline-block object-contain w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10"
                          src={ladderProps.tierImage}
                          alt={ladderProps.tier}
                        />
                      ) : null}
                      <span className="font-bold ms-1">
                        {ladderProps.rank ? ladderProps.rank : ""}
                      </span>
                      <div className="font-bold">
                        {ladderProps.leaguePoints} LP
                      </div>
                    </TooltipTrigger>
                    <TooltipContent>{ladderProps.tier}</TooltipContent>
                  </Tooltip>
                </TooltipProvider>
              </TableCell>

              {/* W/L */}
              <TableCell className="px-2 py-3 text-center">
                <span className="font-bold text-green-600 dark:text-green-500">
                  {ladderProps.wins}
                </span>
                /
                <span className="font-bold text-red-600 dark:text-red-500">
                  {ladderProps.losses}
                </span>
              </TableCell>

              {/* WR */}
              <TableCell className="px-2 py-3 font-bold text-center">
                {ladderProps.winRate ? ladderProps.winRate : ""}%
              </TableCell>

              {/* Team */}
              <TableCell className="px-2 py-3 text-center">
                {ladderProps.teams && ladderProps.teams.length > 0
                  ? ladderProps.teams.map((team, teamIndex) => (
                      <div
                        key={teamIndex}
                        className="inline-block me-1 sm:me-2"
                      >
                        <TooltipProvider>
                          <Tooltip>
                            <TooltipTrigger>
                              <img
                                className="inline-block object-contain w-6 h-6 sm:w-8 sm:h-8"
                                src={team.image}
                                alt={team.name}
                              />
                            </TooltipTrigger>
                            <TooltipContent>{team.name}</TooltipContent>
                          </Tooltip>
                        </TooltipProvider>
                      </div>
                    ))
                  : null}
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </>
  );
}
