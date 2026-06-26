import { motion } from "motion/react";

interface RGBBorderProps {
  height?: string;
  className?: string;
  disabled?: boolean;
  activeColor?: string;
  stylePreset?: string;
  speed?: "slow" | "medium" | "fast";
}

export default function RGBBorder({ 
  height = "h-[3px]", 
  className = "", 
  disabled = false, 
  activeColor = "#00f0ff",
  stylePreset = "classic_neo",
  speed = "medium"
}: RGBBorderProps) {
  if (disabled) {
    // Return null so absolutely no glowing border/lighting line renders when off
    return null;
  }

  // Speed mapping to seconds
  const speedDuration = 
    speed === "slow" ? 20 : 
    speed === "fast" ? 4 : 10;

  // Render gradient depending on stylePreset
  let gradientClass = "bg-gradient-to-r from-cyan-500 via-pink-500 via-yellow-400 via-emerald-400 to-cyan-500";
  let glowShadow = "0 0 12px rgba(0, 240, 255, 0.7), 0 0 4px rgba(255, 0, 128, 0.5)";

  switch (stylePreset) {
    case "spinning_rainbow":
      gradientClass = "bg-gradient-to-r from-red-500 via-yellow-400 via-emerald-400 via-cyan-400 via-purple-500 via-pink-500 to-red-500 animate-[hue-rotate_8s_linear_infinite]";
      glowShadow = "0 0 16px rgba(0, 240, 255, 0.8), 0 0 6px rgba(252, 211, 77, 0.6)";
      break;
    case "adsense_safe":
      // Clean, professional, safe neutral boundary format
      gradientClass = "bg-[#1e293b]";
      glowShadow = "none";
      break;
    case "aurora_glow":
      gradientClass = "bg-gradient-to-r from-teal-400 via-indigo-500 via-purple-600 via-emerald-500 to-teal-400";
      glowShadow = "0 0 12px rgba(99, 102, 241, 0.8), 0 0 4px rgba(16, 185, 129, 0.5)";
      break;
    case "toxic_matrix":
      gradientClass = "bg-gradient-to-r from-[#39ff14] via-emerald-600 via-green-400 via-emerald-500 to-[#39ff14]";
      glowShadow = "0 0 12px rgba(57, 255, 20, 0.8), 0 0 4px rgba(16, 185, 129, 0.6)";
      break;
    case "electric_sunset":
      gradientClass = "bg-gradient-to-r from-pink-500 via-purple-600 via-amber-400 to-pink-500";
      glowShadow = "0 0 12px rgba(236, 72, 153, 0.8), 0 0 4px rgba(217, 119, 6, 0.5)";
      break;
    case "cyber_amber":
      gradientClass = "bg-gradient-to-r from-yellow-500 via-amber-600 via-orange-400 to-yellow-500";
      glowShadow = "0 0 12px rgba(245, 158, 11, 0.8), 0 0 4px rgba(234, 179, 8, 0.5)";
      break;
    case "neon_blue_mono":
      gradientClass = "bg-gradient-to-r from-cyan-400 via-blue-500 via-[#00f0ff] to-cyan-400";
      glowShadow = "0 0 15px rgba(6, 182, 212, 0.9), 0 0 4px rgba(59, 130, 246, 0.6)";
      break;
    case "classic_neo":
    default:
      gradientClass = "bg-gradient-to-r from-red-500 via-yellow-400 via-cyan-400 to-indigo-500";
      glowShadow = "0 0 12px rgba(0, 240, 255, 0.7), 0 0 4px rgba(255, 0, 128, 0.5)";
      break;
  }

  return (
    <div className={`relative w-full overflow-hidden ${height} ${className}`}>
      {/* Absolute high-contrast futuristic linear gradient animating across */}
      <motion.div
        className={`absolute inset-0 w-[400%] h-full ${gradientClass}`}
        animate={{
          x: ["0%", "-50%"],
        }}
        transition={{
          repeat: Infinity,
          duration: speedDuration,
          ease: "linear",
        }}
        style={{
          boxShadow: glowShadow,
        }}
      />
    </div>
  );
}
